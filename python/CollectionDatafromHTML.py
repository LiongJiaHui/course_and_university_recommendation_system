from flask import Flask, request, jsonify
from flask_cors import CORS
import GenerateUniversityList as gen
import math
import pandas as pd
from datetime import datetime

# input data have to import the data from the html side 
app = Flask(__name__)
CORS(app)  # Allow requests from Laravel frontend

def clean_nans(obj):
    if isinstance(obj, dict):
        return {k: clean_nans(v) for k, v in obj.items()}
    elif isinstance(obj, list):
        return [clean_nans(i) for i in obj]
    elif isinstance(obj, float) and math.isnan(obj):
        return None
    return obj

@app.route('/final_submit', methods=['POST'])
def collection_of_data():
    try:
        start = datetime.now()

        data = request.json
        print("Data Received from Laravel: ", data)

         # Get recommendation DataFrame or list
        recommendation_df = gen.generate_university_list(data)

        # If it's a DataFrame, convert to a list of dicts
        if hasattr(recommendation_df, "to_dict"):
            recommendation_df = recommendation_df.where(pd.notnull(recommendation_df), None)
            recommendation_list = recommendation_df.to_dict(orient="records")
        else:
            recommendation_list = clean_nans(recommendation_df)

        # print(recommendation_list)
        end = datetime.now()
        elapsed = end - start
        print("Time taken for the python script: ", elapsed)

        return jsonify(recommendation_list)
    except Exception as e:
        import traceback
        print("Error:", e)
        traceback.print_exc()
        return jsonify({"error": str(e)}), 500


if __name__ == "__main__": 
    app.run(host='127.0.0.1', port=5000,debug=True)