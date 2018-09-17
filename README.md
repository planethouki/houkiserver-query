# houkiserver-query

Run on Azure Webapp (Windows)

Extension: composer

demo: https://houkiserverquery.azurewebsites.net/


response sample (200 OK)

```json
{
  "description": {
    "text": "HoukiServer since 2017.01.29"
  },
  "players": {
    "max": 20,
    "online": 0
  },
  "version": {
    "name": "Spigot 1.12.2",
    "protocol": 340
  },
  "favicon": "data:image/png;base64,iVBORw0KGgo......."
}
```

error sample (500 Internal Server Error)

```json
{
  "message": "Failed to connect or create a socket: 110 (Connection timed out)"
}
```