const fs = require('fs');

// File paths
const inputFile = __dirname+'/windows-tzid-mapping.json';
const outputFile = __dirname+'/windows-tzid-mapping-arrays.json';

// Load the JSON data
const data = JSON.parse(fs.readFileSync(inputFile, 'utf8'));

// Process the data
data.forEach(entry => {
    if (entry.TZID) {
        // Split the TZID field into an array if it contains multiple timezones
        const timezones = entry.TZID.split(' ');
        entry.TZID = timezones;
    }
});

// Save the updated data to a new file
fs.writeFileSync(outputFile, JSON.stringify(data, null, 4), 'utf8');

console.log(`Converted file saved as ${outputFile}`);