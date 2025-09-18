import unittest
from unittest.mock import patch
import findTheDistance as distance  # your module


class TestGeocodeFunctions(unittest.TestCase):

    @patch("findTheDistance.requests.get")
    def test_geocode_address_success(self, mock_get):
        mock_get.return_value.json.return_value = [
            {"lat": "3.1390", "lon": "101.6869"}  # KL coords
        ]
        coords = distance.geocode_address("Kuala Lumpur, Malaysia")
        self.assertEqual(coords, (3.1390, 101.6869))

    @patch("findTheDistance.requests.get")
    def test_geocode_address_fallback(self, mock_get):
        mock_get.side_effect = [
            type("obj", (), {"json": lambda self: []})(),  # first call returns empty
            type("obj", (), {"json": lambda self: [{"lat": "2.7297", "lon": "101.9381"}]})(),  # fallback
        ]
        coords = distance.geocode_address("Some Unknown Building, Nilai, Malaysia")
        self.assertEqual(coords, (2.7297, 101.9381))

    @patch("findTheDistance.requests.get")
    def test_find_the_distance_osrm_success(self, mock_get):
        distance.geocode_cache.clear()
        distance.geocode_cache["Home"] = (3.1390, 101.6869)
        distance.geocode_cache["University"] = (2.9297, 101.9381)

        mock_get.return_value.json.return_value = {"routes": [{"distance": 40000}]}
        result = distance.find_the_distance_V3("University", "Home")
        self.assertEqual(result, 40.00)

    @patch("findTheDistance.requests.get")
    def test_find_the_distance_osrm_fallback(self, mock_get):
        distance.geocode_cache.clear()
        distance.geocode_cache["Home"] = (3.1390, 101.6869)
        distance.geocode_cache["University"] = (3.0738, 101.6070)

        mock_get.side_effect = Exception("OSRM unavailable")

        result = distance.find_the_distance_V3("University", "Home")
        self.assertAlmostEqual(
            result,
            distance.geodesic((3.1390, 101.6869), (3.0738, 101.6070)).km,
            places=2,
        )

    def test_cached_geocode(self):
        distance.geocode_cache.clear()
        distance.geocode_cache["Kuala Lumpur"] = (3.1390, 101.6869)
        coords = distance.cached_geocode("Kuala Lumpur")
        self.assertEqual(coords, (3.1390, 101.6869))


class TestFindTheDistanceFeature(unittest.TestCase):

    def test_real_geocode_and_distance(self):
        input_address = "George Town, Penang, Malaysia"
        dataset_address = "Universiti Malaya, 50603 Kuala Lumpur, Malaysia"

        result = distance.find_the_distance_V3(dataset_address, input_address)
        self.assertGreater(result, 293)
        self.assertLess(result, 354)

    @patch("findTheDistance.requests.get")
    def test_distance_with_osrm(self, mock_get):
        mock_get.side_effect = [
            type("obj", (), {"json": lambda: [{"lat": "3.1390", "lon": "101.6869"}]}),
            type("obj", (), {"json": lambda: [{"lat": "5.4112", "lon": "100.3354"}]}),
            type("obj", (), {"json": lambda: {"routes": [{"distance": 350000.0}]}}),
        ]
        distance.geocode_cache.clear()
        result = distance.find_the_distance_V3("Penang, Malaysia", "Kuala Lumpur, Malaysia")
        self.assertEqual(result, 350.0)

    @patch("findTheDistance.requests.get")
    def test_distance_with_fallback_geodesic(self, mock_get):
        mock_get.side_effect = [
            type("obj", (), {"json": lambda: [{"lat": "3.1390", "lon": "101.6869"}]}),
            type("obj", (), {"json": lambda: [{"lat": "3.0738", "lon": "101.5183"}]}),
            Exception("OSRM API failed"),
        ]
        distance.geocode_cache.clear()
        result = distance.find_the_distance_V3("Cheras, Malaysia", "Kuala Lumpur, Malaysia")
        self.assertTrue(result > 0)


if __name__ == "__main__":
    unittest.main(verbosity=2)
