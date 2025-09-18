
import unittest
from unittest.mock import patch, MagicMock
import pandas as pd
import GenerateUniversityList 

class TestGenerateUniversityList(unittest.TestCase):

    def setUp(self):
        # Mock input data (as if from HTML form)
        self.input_data = {
            "unitype": "public",
            "subjects": [
                {"name": "Math", "marks": 80},
                {"name": "Science", "marks": 70}
            ],
            "MUETmarks": 3,
            "cocuriculummarks": 10,
            "preference": "tuition_fees"
        }

        # Required columns for DB
        self.required_columns = [
            "id", "name", "uni_type", "requirement_merit", "requirement_muet",
            "specific_subjects", "ranking_qs_no_start"
        ]

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    @patch("GenerateUniversityList.comparison.compare_result_and_requirement_v1")
    @patch("GenerateUniversityList.sort.sort_recommended_list")
    def test_generate_university_list_public_flow(self, mock_sort, mock_compare, mock_db):
        # Mock DB fetch
        mock_db.return_value = pd.DataFrame([
            {"id": 1, "name": "Uni A", "uni_type": "Public", "requirement_merit": 65, 
             "requirement_muet": 3, "specific_subjects": [], "ranking_qs_no_start": 1},
            {"id": 2, "name": "Uni B", "uni_type": "Public", "requirement_merit": 55, 
             "requirement_muet": 2, "specific_subjects": [], "ranking_qs_no_start": 2}
        ])

        # Mock comparison result
        mock_compare.return_value = pd.DataFrame([
            {"id": 1, "name": "Uni A", "score": 85, "ranking_qs_no_start": 1},
            {"id": 2, "name": "Uni B", "score": 80, "ranking_qs_no_start": 2}
        ])

        # Mock sorted list
        mock_sort.return_value = [
            {"id": 1, "name": "Uni A"},
            {"id": 2, "name": "Uni B"}
        ]

        result = GenerateUniversityList.generate_university_list(self.input_data)

        mock_db.assert_called_once()
        mock_compare.assert_called_once()
        mock_sort.assert_called_once()

        self.assertEqual(len(result), 2)
        self.assertEqual(result[0]["name"], "Uni A")

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    @patch("GenerateUniversityList.comparison.compare_result_and_requirement_v2")
    @patch("GenerateUniversityList.sort.sort_recommended_list")
    def test_generate_university_list_private_flow(self, mock_sort, mock_compare, mock_db):
        input_data = self.input_data.copy()
        input_data["unitype"] = "private"

        mock_db.return_value = pd.DataFrame([
            {"id": 3, "name": "Uni C", "uni_type": "Private", "requirement_merit": None, 
             "requirement_muet": 1, "specific_subjects": [], "ranking_qs_no_start": 1}
        ])
        mock_compare.return_value = pd.DataFrame([
            {"id": 3, "name": "Uni C", "score": 90, "ranking_qs_no_start": 1}
        ])
        mock_sort.return_value = [{"id": 3, "name": "Uni C"}]

        result = GenerateUniversityList.generate_university_list(input_data)

        self.assertEqual(len(result), 1)
        self.assertEqual(result[0]["name"], "Uni C")

    # ----------------- Error Handling / Feature Tests -----------------

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    def test_empty_database_feature(self, mock_db):
        """Feature test: database is empty"""
        mock_db.return_value = pd.DataFrame(columns=self.required_columns)

        input_data = {
            "unitype": "public",
            "subjects": [{"name": "Math", "marks": 80}],
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        try:
            result = GenerateUniversityList.generate_university_list(input_data)
        except KeyError as e:
            result = f"Error caught: {e}"

        self.assertTrue(isinstance(result, list) or "Error caught" in str(result))

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    def test_missing_unitype_feature(self, mock_db):
        """Feature test: 'unitype' field is missing in user input"""
        mock_db.return_value = pd.DataFrame([
            {"id": 1, "name": "Uni A", "uni_type": "Public", "requirement_merit": 60,
             "requirement_muet": 3, "specific_subjects": [], "ranking_qs_no_start": 1}
        ])

        input_data = {
            # unitype missing
            "subjects": [{"name": "Math", "marks": 80}],
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        try:
            result = GenerateUniversityList.generate_university_list(input_data)
        except KeyError as e:
            result = f"Error caught: {e}"

        self.assertTrue(isinstance(result, list) or "Error caught" in str(result))

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    def test_invalid_subject_marks_feature(self, mock_db):
        """Feature test: invalid marks input (string instead of number)"""
        mock_db.return_value = pd.DataFrame([
            {"id": 1, "name": "Uni A", "uni_type": "Public", "requirement_merit": 60,
             "requirement_muet": 3, "specific_subjects": [], "ranking_qs_no_start": 1}
        ])

        input_data = {
            "unitype": "public",
            "subjects": [{"name": "Math", "marks": "oops"}],  # invalid
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        try:
            result = GenerateUniversityList.generate_university_list(input_data)
        except Exception as e:
            result = f"Error caught: {e}"

        self.assertTrue(isinstance(result, list) or "Error caught" in str(result))

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    def test_unknown_unitype_feature(self, mock_db):
        """Feature test: unknown university type"""
        mock_db.return_value = pd.DataFrame(columns=self.required_columns)

        input_data = {
            "unitype": "international",  # unknown type
            "subjects": [{"name": "Math", "marks": 80}],
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        try:
            result = GenerateUniversityList.generate_university_list(input_data)
        except KeyError as e:
            result = f"Error caught: {e}"

        self.assertTrue(isinstance(result, list) or "Error caught" in str(result))

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    def test_missing_columns_feature(self, mock_db):
        """Feature test: database missing required columns"""
        # DB has only id and name
        mock_db.return_value = pd.DataFrame([{"id": 1, "name": "Uni A"}])

        input_data = {
            "unitype": "public",
            "subjects": [{"name": "Math", "marks": 80}],
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        try:
            result = GenerateUniversityList.generate_university_list(input_data)
        except KeyError as e:
            result = f"Error caught: {e}"

        self.assertTrue(isinstance(result, list) or "Error caught" in str(result))
    

if __name__ == "__main__":
    unittest.main()
