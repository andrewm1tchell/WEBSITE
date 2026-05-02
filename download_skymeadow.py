import os
import requests
import json

output_dir = "/Users/andrewmitchell/Downloads/art/images/skymeadow"
os.makedirs(output_dir, exist_ok=True)

base_url = "https://arweave.net/5Mnn8JwjxdWJRx_BNGH7y5HJgBvWShT3NAFnQtcRQao"

for i in range(1, 556):
    try:
        # Get JSON metadata
        json_url = f"{base_url}/{i}"
        response = requests.get(json_url, timeout=30)
        data = response.json()

        # Get image URL
        img_url = data.get("image")
        if img_url:
            # Download image
            img_response = requests.get(img_url, timeout=60)
            img_path = os.path.join(output_dir, f"{i}.png")
            with open(img_path, "wb") as f:
                f.write(img_response.content)
            print(f"Downloaded {i}/555")
        else:
            print(f"No image URL for {i}")
    except Exception as e:
        print(f"Error downloading {i}: {e}")

print("Done!")

