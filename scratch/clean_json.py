import json
import os

file_path = r'c:\xampp\htdocs\assets\gallery_data.json'

try:
    with open(file_path, 'r', encoding='utf-8') as f:
        data = json.load(f)
    
    print(f"Original items count: {len(data)}")
    
    cleaned_data = []
    for item in data:
        title = item.get('title', '')
        # If title is suspiciously long (e.g. > 500 chars) or contains many weird characters, we fix it
        if len(title) > 500:
            print(f"Cleaning corrupted title for item: {item.get('src')}")
            item['title'] = "Düzeltilmiş Başlık"
        cleaned_data.append(item)
        
    with open(file_path, 'w', encoding='utf-8') as f:
        json.dump(cleaned_data, f, indent=2, ensure_ascii=False)
    
    print("Cleanup successful.")

except Exception as e:
    print(f"Error: {e}")
