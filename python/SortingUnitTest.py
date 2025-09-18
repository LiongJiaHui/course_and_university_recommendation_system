import unittest
from unittest.mock import patch
import pandas as pd
import Sorting

class TestSortingFunction(unittest.TestCase):
    def setUp(self):
        # Fake compared_result dataframe
        self.compared_result = pd.DataFrame([
            {"id": 1, "state_name": "Selangor", "course_aspect": "Engineering", "tuition_fees": 30000, "uni_address": "Uni A", "area_name": "Shah Alam", "ranking_qs_no_start": 200},
            {"id": 2, "state_name": "Kuala Lumpur", "course_aspect": "Business", "tuition_fees": 50000, "uni_address": "Uni B", "area_name": "KL", "ranking_qs_no_start": 100},
            {"id": 3, "state_name": "Penang", "course_aspect": "IT", "tuition_fees": 25000, "uni_address": "Uni C", "area_name": "George Town", "ranking_qs_no_start": 300},
        ])

        # Default input data
        self.input_data_html = {
            "location": "Selangor",
            "area_of_interest": "Engineering",
            "tuition_fees_start": 20000,
            "tuition_fees_end": 40000,
            "address": "123 Jalan Ampang",
            "area": "Ampang",
            "state": "Selangor"
        }

    def test_sort_by_location(self):
        result = Sorting.sort_recommended_list(self.input_data_html, self.compared_result, ["location"])
        self.assertTrue(all(r["state_name"] == "Selangor" for r in result))

    def test_sort_by_area_of_interest(self):
        result = Sorting.sort_recommended_list(self.input_data_html, self.compared_result, ["area_of_interest"])
        self.assertTrue(all(r["course_aspect"] == "Engineering" for r in result))

    def test_sort_by_expected_fees(self):
        result = Sorting.sort_recommended_list(self.input_data_html, self.compared_result, ["expected_fees"])
        fees = [r["tuition_fees"] for r in result]
        self.assertEqual(fees, sorted(fees))  # must be sorted

    @patch("findTheDistance.find_the_distance_V3", return_value=10.5)
    def test_sort_by_shortest_distance(self, mock_distance):
        result = Sorting.sort_recommended_list(self.input_data_html, self.compared_result, ["shortest_distance"])

         # If distances applied correctly
        if "distance" in result[0]:
            self.assertIn("distance", result[0])
            self.assertEqual(mock_distance.call_count, len(result))
        else:
            # Fallback case → check QS ranking instead
            rankings = [r["ranking_qs_no_start"] for r in result]
            self.assertEqual(rankings, sorted(rankings))
        # distance should be added
        self.assertEqual(mock_distance.call_count, len(self.compared_result))

    def test_default_sort_when_no_preferences(self):
        result = Sorting.sort_recommended_list(self.input_data_html, self.compared_result, [])
        rankings = [r["ranking_qs_no_start"] for r in result]
        self.assertEqual(rankings, sorted(rankings))

    # Error handling test
    def test_invalid_preference_type(self):
        """preferences is a string, should auto-wrap into list"""
        result = Sorting.sort_recommended_list(self.input_data_html, self.compared_result, "location")
        self.assertTrue(all(r["state_name"] == "Selangor" for r in result))

    # def test_unknown_preference(self):
    #     """Unknown preference should just return QS ranking sort"""
    #     result = Sorting.sort_recommended_list(self.input_data_html, self.compared_result, ["random_pref"])
    #     self.assertEqual(result[0]["id"], 1)

    def test_missing_column_in_dataframe(self):
        """Missing tuition_fees should not break expected_fees branch"""
        broken_df = pd.DataFrame([{"id": 1, "state_name": "Selangor"}])
        try:
            Sorting.sort_recommended_list(self.input_data_html, broken_df, ["expected_fees"])
        except Exception as e:
            self.fail(f"Raised unexpectedly: {e}")

    def test_invalid_fee_range(self):
        """start > end → should return empty"""
        bad_input = self.input_data_html.copy()
        bad_input["tuition_fees_start"] = 40000
        bad_input["tuition_fees_end"] = 20000
        result = Sorting.sort_recommended_list(bad_input, self.compared_result, ["expected_fees"])
        self.assertEqual(result, [])

    @patch("findTheDistance.find_the_distance_V3", side_effect=Exception("API error"))
    def test_distance_api_failure(self, mock_distance):
        """If distance API fails, should not crash"""
        try:
            Sorting.sort_recommended_list(self.input_data_html, self.compared_result, ["shortest_distance"])
        except Exception as e:
            self.fail(f"Raised unexpectedly: {e}")


if __name__ == "__main__":
    unittest.main()