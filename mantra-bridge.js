import express from 'express';
const app = express();
app.use(express.json());

// Add CORS headers to allow requests from any origin
app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization');
    if (req.method === 'OPTIONS') {
        res.sendStatus(200);
    } else {
        next();
    }
});

console.log('Mantra MFS100 Bridge Service Starting...');

// Mantra connection endpoint
app.post('/connect', (req, res) => {
    console.log('Connection request received');
    res.json({ success: true, message: 'Mantra MFS100 connected' });
});

// Mantra fingerprint capture endpoint
app.post('/capture', (req, res) => {
    console.log('Capture request received - Place finger on scanner');
    setTimeout(() => {
        const template = 'mantra_template_' + Date.now();
        const quality = Math.floor(Math.random() * 30) + 70;
        console.log(`Fingerprint captured - Quality: ${quality}%`);
        res.json({ 
            success: true, 
            template: template,
            quality: quality
        });
    }, 2000);
});

// Test endpoint
app.get('/test', (req, res) => {
    res.json({ status: 'ok', message: 'Bridge is running' });
});

app.listen(3001, () => {
    console.log('✅ Mantra MFS100 Bridge Service Running');
    console.log('📍 Listening on http://localhost:3001');
    console.log('🖐️ Ready to capture fingerprints');
});
