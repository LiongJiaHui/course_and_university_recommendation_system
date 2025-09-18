import unittest
import pandas as pd
import CollectionDataFromDatabase  

class TestCollectionDataIntegration(unittest.TestCase):

    def test_collection_data_from_real_db(self):
        df = CollectionDataFromDatabase.collection_data_from_database()

        # Assertions on schema
        expected_cols = [
            "id", "course_honour_name", "tuition_fees", "uni_name",
            "state_name", "area_name", "course_category"
        ]
        for col in expected_cols:
            self.assertIn(col, df.columns)

        # Assertions on content (if you seeded data)
        self.assertTrue(len(df) > 0, "Dataset should not be empty")
        self.assertTrue(df["tuition_fees"].dtype in ["int64", "float64", "object"])

if __name__ == "__main__":
    unittest.main()