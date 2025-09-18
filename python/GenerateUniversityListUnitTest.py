# test_generate_university_list_unit.py
import unittest
from unittest.mock import patch, MagicMock
import pandas as pd
from datetime import datetime
import GenerateUniversityList


class TestGenerateUniversityListUnit(unittest.TestCase):

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    @patch("GenerateUniversityList.comparison.compare_result_and_requirement_v1")
    @patch("GenerateUniversityList.sort.sort_recommended_list")
    def test_generate_list_public(self, mock_sort, mock_compare, mock_db):
        # Fake DB
        fake_db = pd.DataFrame([
            {"id": 1, "uni_type": "Public", "course_name": "Engineering"},
            {"id": 2, "uni_type": "Private", "course_name": "Business"}
        ])
        mock_db.return_value = fake_db

        # Fake compare result
        mock_compare.return_value = pd.DataFrame([
            {"id": 1, "course_name": "Engineering", "score": 95}
        ])

        # Fake sorted output
        mock_sort.return_value = [
            {"id": 1, "course_name": "Engineering", "score": 95}
        ]

        input_data = {
            "unitype": "public",
            "subjects": [{"marks": 3.5}, {"marks": 3.0}, {"marks": 4.0}, {"marks": 3.8}],
            "MUETmarks": 3.5,
            "cocuriculummarks": 8.0,
            "preference": {"location": "KL"}
        }

        result = GenerateUniversityList.generate_university_list(input_data)

        self.assertEqual(len(result), 1)
        self.assertEqual(result[0]["course_name"], "Engineering")

        mock_db.assert_called_once()
        mock_compare.assert_called_once()
        mock_sort.assert_called_once()

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    @patch("GenerateUniversityList.comparison.compare_result_and_requirement_v2")
    @patch("GenerateUniversityList.sort.sort_recommended_list")
    def test_generate_list_private(self, mock_sort, mock_compare, mock_db):
        fake_db = pd.DataFrame([
            {"id": 10, "uni_type": "Private", "course_name": "IT"},
        ])
        mock_db.return_value = fake_db

        mock_compare.return_value = pd.DataFrame([
            {"id": 10, "course_name": "IT", "score": 88}
        ])
        mock_sort.return_value = [
            {"id": 10, "course_name": "IT", "score": 88}
        ]

        input_data = {
            "unitype": "private",
            "subjects": [{"marks": 2.5}],
            "MUETmarks": 2.0,
            "preference": {"tuition": "low"}
        }

        result = GenerateUniversityList.generate_university_list(input_data)

        self.assertEqual(result[0]["course_name"], "IT")
        mock_compare.assert_called_once()
        mock_sort.assert_called_once()

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    @patch("GenerateUniversityList.comparison.compare_result_and_requirement_v1")
    @patch("GenerateUniversityList.sort.sort_recommended_list")
    def test_invalid_subject_marks(self, mock_sort, mock_compare, mock_db):
        # Mock DB with public uni
        mock_db.return_value = pd.DataFrame([
            {"id": 1, "name": "Uni A", "uni_type": "Public", "requirement_merit": 60, "requirement_muet": 3}
        ])

        # Comparison returns a simple DataFrame
        mock_compare.return_value = pd.DataFrame([{"id": 1, "name": "Uni A"}])
        mock_sort.return_value = [{"id": 1, "name": "Uni A"}]

        input_data = {
            "unitype": "public",
            "subjects": [{"name": "Math", "marks": "oops"}],  # invalid mark (string)
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        result = GenerateUniversityList.generate_university_list(input_data)
        self.assertTrue(len(result) > 0)  # still works despite invalid mark

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    @patch("GenerateUniversityList.sort.sort_recommended_list")
    def test_missing_unitype(self, mock_sort, mock_db):
        mock_db.return_value = pd.DataFrame([
            {"id": 1, "name": "Uni A", "uni_type": "Public", "requirement_merit": 60, "requirement_muet": 3}
        ])
        mock_sort.return_value = []

        input_data = {
            # "unitype" is missing
            "subjects": [{"name": "Math", "marks": 80}],
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        result = GenerateUniversityList.generate_university_list(input_data)
        self.assertEqual(result, [])  # should return empty

    @patch("GenerateUniversityList.sort.sort_recommended_list")
    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    def test_unknown_university_type(self, mock_db, mock_sort):
        mock_db.return_value = pd.DataFrame(columns=["id", "uni_type", "specific_subjects"])
        mock_sort.return_value = []

        input_data = {
            "unitype": "international",  # unsupported type
            "subjects": [{"marks": 80}],
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        result = GenerateUniversityList.generate_university_list(input_data)
        self.assertEqual(result, [])  # should return empty since no path executed

    @patch("GenerateUniversityList.inputDatabase.collection_data_from_database")
    @patch("GenerateUniversityList.comparison.compare_result_and_requirement_v1")
    @patch("GenerateUniversityList.sort.sort_recommended_list") 
    def test_empty_database(self,mock_sort, mock_compare, mock_db):
        # Empty DB
        mock_db.return_value = pd.DataFrame(
            columns=["id", "name", "uni_type", "merit_mark", "requirement_muet", "specific_subjects"]
        )
        
        # comparison should return empty DataFrame with all expected columns
        mock_compare.return_value = pd.DataFrame(columns=["ranking_qs_no_start"])

        # Sorting returns empty list
        mock_sort.return_value = []

        input_data = {
            "unitype": "public",
            "subjects": [{"name": "Math", "marks": 80}],
            "MUETmarks": 3,
            "cocuriculummarks": 5,
            "preference": "fees"
        }

        result = GenerateUniversityList.generate_university_list(input_data)
        self.assertEqual(result, [])


if __name__ == "__main__":
    unittest.main()
