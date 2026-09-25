from flask import Flask, request, jsonify
import requests
from thefuzz import fuzz

app = Flask(__name__)
EXPECTED_API_KEY = "classifier-key2-kertaskerja-prq"

LOCATION_WORDS = {
    "kantor", "ktr", "rumdin", "rumah dinas", "mako", "rupat", 
    "ruang rapat", "gedung", "aula", "pendopo", "posko"
}

def get_master_data():
    master_url = "http://localhost:8000/api/classifier/master"
    master_headers = {
        "Authorization": "Bearer classifier-key-kertaskerja-prq",
        "Accept": "application/json"
    }
    try:
        response = requests.get(master_url, headers=master_headers, timeout=5)
        if response.status_code == 200:
            return response.json().get('data', [])
    except Exception as e:
        print("Gagal ambil master data:", e)
    return []

@app.route('/api/classifier-py', methods=['POST'])
def receive_activity():
    auth_header = request.headers.get('Authorization')
    if auth_header != f"Bearer {EXPECTED_API_KEY}":
        return jsonify({"error": "Unauthorized"}), 401

    payload = request.get_json()
    if not payload:
        return jsonify({"error": "Payload kosong"}), 400

    activity_id = payload.get("id")
    activity_notes = payload.get("activity_notes", "")
    print("DATA MASUK:", payload)

    master_data = get_master_data()
    
    notes_lower = activity_notes.lower()
    cleaned_notes = notes_lower
    words_in_notes = cleaned_notes.split()
    
    for i in range(len(words_in_notes)):
        if words_in_notes[i] in LOCATION_WORDS:
            cleaned_notes = cleaned_notes.replace(words_in_notes[i], "", 1)
            if i + 1 < len(words_in_notes):
                next_word = words_in_notes[i + 1]
                cleaned_notes = cleaned_notes.replace(next_word, "", 1)

    matched_candidates = {}

    for item in master_data:
        entity = item.get("entity")
        category = item.get("category")

        if not entity:
            continue

        entity_lower = entity.lower()
        matched_method = None
        score_val = 0.0

        if entity_lower in cleaned_notes:
            matched_method = "exact"
            score_val = 1.0
        else:
            partial_score = fuzz.partial_ratio(entity_lower, cleaned_notes)
            if partial_score >= 70: 
                matched_method = "fuzzy"
                score_val = round(partial_score / 100.0, 2)

        if matched_method:
            if entity_lower not in matched_candidates:
                matched_candidates[entity_lower] = {
                    "category": category,
                    "entity": entity,
                    "score": score_val,
                    "Match_method": matched_method
                }
            else:
                existing = matched_candidates[entity_lower]
                if score_val > existing["score"] or (score_val == existing["score"] and matched_method == "exact" and existing["Match_method"] != "exact"):
                    matched_candidates[entity_lower] = {
                        "category": category,
                        "entity": entity,
                        "score": score_val,
                        "Match_method": matched_method
                    }

    found_classifications = list(matched_candidates.values())

    if not found_classifications:
        result = {
            "id": activity_id,
            "status": "no_match",
            "classifications": []
        }
    else:
        has_review = any(c["Match_method"] == "fuzzy" or c["score"] < 1.0 for c in found_classifications)
        status_str = "review_required" if has_review else "matched"
        
        result = {
            "id": activity_id,
            "status": status_str,
            "classifications": found_classifications
        }
    return jsonify(result), 200

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)