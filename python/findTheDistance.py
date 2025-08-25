
from geopy.geocoders import Nominatim 
from geopy.distance import geodesic

import requests
import time

geocode_cache = {}

def cached_geocode(address):
    if address in geocode_cache:
        return geocode_cache[address]
    coords = geocode_address(address)  # your existing function
    geocode_cache[address] = coords
    return coords

def geocode_address(address):
    """Convert address string to (lat, lon) using Nominatim with better fallback."""
    url = "https://nominatim.openstreetmap.org/search"
    headers = {"User-Agent": "distance-script"}

    def query(addr):
        params = {"q": addr, "format": "json", "limit": 1}
        return requests.get(url, params=params, headers=headers).json()

    # First try full address
    response = query(address)

    # If failed, try without building name
    if not response:
        parts = address.split(",")
        if len(parts) > 2:
            fallback = ", ".join(parts[-3:])  # Just city, state, country
            # time.sleep(1)  # avoid rate limit
            response = query(fallback)

    # If still failed, try just city + country
    if not response:
        parts = address.split(",")
        if len(parts) > 1:
            fallback = ", ".join(parts[-2:])
            # time.sleep(1)
            response = query(fallback)

    if response:
        lat = float(response[0]['lat'])
        lon = float(response[0]['lon'])
        return lat, lon
    else:
        raise ValueError(f"Address not found after retries: {address}")

def find_the_distance_V3(dataset_address, input_address):

    # input_address = "Taragon Puteri Cheras, 43200 Cheras, Selangor"
    # dataset_address = "Jalan Sungai Long, Bandar Sungai Long, 43000 Kajang, Selangor"

    lat1, lon1 = cached_geocode(input_address)
    lat2, lon2 = cached_geocode(dataset_address)

    try:
        url = f"http://router.project-osrm.org/route/v1/driving/{lon1},{lat1};{lon2},{lat2}?overview=false"
        response = requests.get(url, timeout=5).json()
        
        if "routes" in response and response["routes"]:
            return round(response['routes'][0]['distance'] / 1000, 2)
    except Exception as e:
        print("Error in Find the distance: " + e)
        pass
        
    print("Completed the the calculation distance between the home address and university address")

    # fallback
    return round(geodesic((lat1, lon1), (lat2, lon2)).km, 2)


if __name__ == "__main__":
    
    find_the_distance_V3()