import unittest
from unittest.mock import patch
import pandas as pd
import Sorting

class TestSortingFeature(unittest.TestCase):
   
    def setUp(self):
        # Fake dataset with varied states, aspects, fees, and rankings
        self.compared_result = pd.DataFrame([
            {"id": 1, "state_name": "Selangor", "course_aspect": "Engineering", "tuition_fees": 30000, "uni_address": "Uni A", "area_name": "Shah Alam", "ranking_qs_no_start": 200},
            {"id": 2, "state_name": "Selangor", "course_aspect": "Engineering", "tuition_fees": 25000, "uni_address": "Uni B", "area_name": "PJ", "ranking_qs_no_start": 150},
            {"id": 3, "state_name": "Kuala Lumpur", "course_aspect": "Business", "tuition_fees": 28000, "uni_address": "Uni C", "area_name": "KL", "ranking_qs_no_start": 100},
            {"id": 4, "state_name": "Penang", "course_aspect": "Engineering", "tuition_fees": 35000, "uni_address": "Uni D", "area_name": "George Town", "ranking_qs_no_start": 300},
        ])

        self.input_data_html = {
            "location": "Selangor",
            "area_of_interest": "Engineering",
            "tuition_fees_start": 20000,
            "tuition_fees_end": 32000,
            "address": "123 Jalan Ampang",
            "area": "Ampang",
            "state": "Selangor"
        }


    @patch("Sorting.ftd.find_the_distance_V3", side_effect=[12.0, 7.0])
    def test_sort_with_multiple_preferences(self, mock_distance):
        """
        Preferences applied in sequence:
        1. Filter by location (Selangor) → keeps ID 1 & 2
        2. Filter by area_of_interest (Engineering) → still ID 1 & 2
        3. Filter by tuition fees (20000–32000) → still ID 1 & 2
        4. Sort by shortest distance → ID 2 (7 km) before ID 1 (12 km)
        """
        result = Sorting.sort_recommended_list(
            self.input_data_html,
            self.compared_result,
            ["location", "area_of_interest", "expected_fees", "shortest_distance"]
        )

        ids = [r["id"] for r in result]
        self.assertEqual(ids, [2, 1])  # Correct order after full pipeline


if __name__ == "__main__":
    unittest.main()