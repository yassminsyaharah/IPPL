curl -X POST "https://places.googleapis.com/v1/places:searchText" -H "X-Goog-Api-Key: YOUR_API_KEY" -H "X-Goog-FieldMask: places.displayName,places.formattedAddress,places.priceLevel" -d "{\"textQuery\":\"Surf Spot in Indonesia\"}"

pause