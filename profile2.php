<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zotero API Data Parser</title>
    <style>
        .item {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 15px;
            border-radius: 5px;
            background-color: #fff;
        }
        .title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .creators {
            color: #34495e;
            font-style: italic;
        }
        .metadata {
            margin-top: 10px;
            color: #7f8c8d;
            font-size: 0.9em;
        }
        .abstract {
            margin-top: 10px;
            font-size: 0.95em;
            line-height: 1.4;
        }
        .error {
            color: #e74c3c;
            padding: 20px;
            text-align: center;
        }
        .loading {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
        }
        body {
            background-color: #f5f6fa;
            font-family: Arial, sans-serif;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div id="loading" class="loading">Loading data...</div>
    <div id="error" class="error" style="display: none;"></div>
    <div id="output"></div>

    <script>
        const ZOTERO_API_URL = 'https://api.zotero.org/groups/5548551/items';

        // Function to parse and display the data
        function displayZoteroData(items) {
            const outputDiv = document.getElementById('output');
            
            items.forEach(item => {
                // Skip attachments
                if (item.data.itemType === 'attachment') return;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'item';
                
                // Add title
                const titleDiv = document.createElement('div');
                titleDiv.className = 'title';
                titleDiv.textContent = item.data.title || 'No title';
                itemDiv.appendChild(titleDiv);
                
                // Add creators if they exist
                if (item.data.creators && item.data.creators.length > 0) {
                    const creatorsDiv = document.createElement('div');
                    creatorsDiv.className = 'creators';
                    const creators = item.data.creators.map(creator => 
                        `${creator.firstName} ${creator.lastName}`
                    ).join(', ');
                    creatorsDiv.textContent = `Authors: ${creators}`;
                    itemDiv.appendChild(creatorsDiv);
                }
                
                // Add metadata
                const metadataDiv = document.createElement('div');
                metadataDiv.className = 'metadata';
                const metadata = [
                    item.data.date && `Date: ${item.data.date}`,
                    item.data.itemType && `Type: ${item.data.itemType}`,
                    item.data.meetingName && `Meeting: ${item.data.meetingName}`,
                    item.data.place && `Place: ${item.data.place}`
                ].filter(Boolean).join(' | ');
                metadataDiv.textContent = metadata;
                itemDiv.appendChild(metadataDiv);
                
                // Add abstract if it exists
                if (item.data.abstractNote) {
                    const abstractDiv = document.createElement('div');
                    abstractDiv.className = 'abstract';
                    abstractDiv.textContent = item.data.abstractNote;
                    itemDiv.appendChild(abstractDiv);
                }
                
                outputDiv.appendChild(itemDiv);
            });
        }

        // Function to fetch data from Zotero API
        async function fetchZoteroData() {
            const loadingDiv = document.getElementById('loading');
            const errorDiv = document.getElementById('error');
            const outputDiv = document.getElementById('output');

            try {
                const ITEMS_PER_PAGE = 100;
                const response = await fetch(`${ZOTERO_API_URL}?limit=${ITEMS_PER_PAGE}&start=0`, {
                    headers: {
                        'Accept': 'application/json',
                        'Zotero-API-Key': 'CCH8i9wrJ1cE1pqBh5EQ2BAF'
                    }
                });
               

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                loadingDiv.style.display = 'none';
                displayZoteroData(data);

            } catch (error) {
                loadingDiv.style.display = 'none';
                errorDiv.style.display = 'block';
                errorDiv.textContent = `Error loading data: ${error.message}`;
                console.error('Error:', error);
            }
        }

        // Call the function when the page loads
        document.addEventListener('DOMContentLoaded', fetchZoteroData);
    </script>
</body>
</html>
