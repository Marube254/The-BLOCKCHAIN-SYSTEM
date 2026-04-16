<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IUEA Voting System | Blockchain-Powered Elections</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .vote-card { transition: all 0.25s ease; cursor: pointer; }
        .vote-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
        .selected-candidate { border-left: 4px solid #8B0000; background: #fef2f2; }
        .btn-primary { background: #8B0000; transition: all 0.2s; }
        .btn-primary:hover { background: #6a0000; transform: scale(0.98); }
        .toast { animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
    </style>
</head>
<body class="bg-gray-50">

<div id="app">
    <!-- AUTH PAGE -->
    <div id="authPage" class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-[#8B0000] rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-university text-white text-2xl"></i>
                </div>
                <h2 class="mt-4 text-2xl font-bold">IUEA Voting System</h2>
                <p class="text-gray-500 text-sm">Blockchain-Powered Student Elections</p>
                <div class="mt-2 inline-flex items-center gap-1 bg-purple-100 px-3 py-1 rounded-full">
                    <i class="fas fa-link text-purple-600 text-xs"></i>
                    <span class="text-xs text-purple-600">Blockchain Verified</span>
                </div>
            </div>

            <div class="flex gap-2 mt-6 border-b">
                <button id="showLoginBtn" class="flex-1 py-2 font-semibold text-[#8B0000] border-b-2 border-[#8B0000]">Login</button>
                <button id="showRegisterBtn" class="flex-1 py-2 font-semibold text-gray-500">Register</button>
            </div>

            <!-- LOGIN FORM -->
            <div id="loginForm" class="mt-6 space-y-4">
                <input type="text" id="loginVoterId" placeholder="Admission Number" class="w-full px-4 py-2 border rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
                <input type="password" id="loginPassword" placeholder="Password" class="w-full px-4 py-2 border rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
                <div class="text-right">
                    <button id="forgotPasswordBtn" class="text-sm text-[#8B0000] hover:underline">Forgot Password?</button>
                </div>
                <button id="loginSubmitBtn" class="w-full btn-primary text-white py-2 rounded-lg font-semibold">Login to Vote</button>
            </div>

            <!-- REGISTER FORM -->
            <div id="registerForm" class="mt-6 space-y-4 hidden">
                <input type="text" id="regFirstName" placeholder="First Name" class="w-full px-4 py-2 border rounded-lg">
                <input type="text" id="regLastName" placeholder="Last Name" class="w-full px-4 py-2 border rounded-lg">
                <input type="text" id="regVoterId" placeholder="Admission Number (e.g., IUEA-2026-1234)" class="w-full px-4 py-2 border rounded-lg">
                <input type="email" id="regEmail" placeholder="Email Address" class="w-full px-4 py-2 border rounded-lg">
                <input type="password" id="regPassword" placeholder="Password (min 6 characters)" class="w-full px-4 py-2 border rounded-lg">
                <input type="password" id="regConfirmPassword" placeholder="Confirm Password" class="w-full px-4 py-2 border rounded-lg">
                <button id="registerSubmitBtn" class="w-full btn-primary text-white py-2 rounded-lg font-semibold">Create Account</button>
            </div>

            <!-- FORGOT PASSWORD FORM -->
            <div id="forgotPasswordForm" class="mt-6 space-y-4 hidden">
                <input type="email" id="resetEmail" placeholder="Enter your email address" class="w-full px-4 py-2 border rounded-lg">
                <button id="sendResetLinkBtn" class="w-full btn-primary text-white py-2 rounded-lg">Send Reset Link</button>
                <button id="backToLoginFromReset" class="w-full text-gray-500 py-2 text-sm">Back to Login</button>
            </div>
        </div>
    </div>

    <!-- VOTING PAGE -->
    <div id="votingPage" class="hidden max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">IUEA <span class="text-[#8B0000]">VoteHub</span></h1>
                <p class="text-sm text-gray-500">Blockchain-Powered Student Elections</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-gray-100 px-4 py-2 rounded-full">
                    <i class="fas fa-user text-[#8B0000] mr-2"></i>
                    <span id="voterName" class="text-sm font-medium">Loading...</span>
                </div>
                <button id="logoutBtn" class="text-[#8B0000] hover:bg-red-50 px-3 py-2 rounded-lg"><i class="fas fa-sign-out-alt mr-1"></i>Logout</button>
            </div>
        </div>

        <!-- Blockchain Status -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg p-3 mb-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-link text-white"></i>
                <span class="text-white text-sm">Blockchain Verified Voting</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-300"></i>
                <span class="text-white text-xs">Immutable • Transparent • Secure</span>
            </div>
        </div>

        <!-- Candidates Grid -->
        <div id="candidatesGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-6"></div>

        <!-- Vote Summary -->
        <div class="mt-8 bg-white rounded-xl border p-6">
            <h3 class="font-bold text-lg mb-3"><i class="fas fa-ballot-check text-[#8B0000] mr-2"></i>Your Vote Summary</h3>
            <div id="voteSummary" class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm"></div>
            <button id="castVoteBtn" class="mt-4 w-full btn-primary text-white py-3 rounded-lg font-semibold">Cast Vote Securely</button>
        </div>
    </div>

    <!-- CONFIRMATION PAGE -->
    <div id="confirmationPage" class="hidden min-h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold mt-4">Vote Successfully Recorded!</h2>
            <p class="text-gray-500 mt-2">Your vote has been secured on the blockchain</p>
            <div class="bg-gray-50 rounded-lg p-4 mt-6 text-left">
                <p class="text-sm font-mono break-all"><strong>Transaction Hash:</strong> <span id="txHash"></span></p>
                <p class="text-sm mt-2"><strong>Timestamp:</strong> <span id="txTime"></span></p>
            </div>
            <button id="newVoteBtn" class="mt-6 btn-primary text-white px-6 py-2 rounded-lg">Return Home</button>
        </div>
    </div>
</div>

<div id="toastContainer" class="fixed bottom-5 right-5 z-50"></div>

<script>
    const API_BASE = '/api';
    let authToken = localStorage.getItem('auth_token');
    let currentVoter = null;
    let candidates = {};
    let selectedVotes = {};

    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast bg-white rounded-lg shadow-xl border-l-8 p-4 mb-2 min-w-[300px]`;
        toast.style.borderLeftColor = type === 'success' ? '#8B0000' : '#dc2626';
        toast.innerHTML = `<div class="flex items-center gap-3"><i class="fas ${type === 'success' ? 'fa-check-circle text-[#8B0000]' : 'fa-exclamation-triangle text-red-500'}"></i><p class="text-sm">${message}</p><button class="ml-auto text-gray-400" onclick="this.parentElement.parentElement.remove()">×</button></div>`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    async function apiCall(endpoint, method = 'GET', data = null) {
        const headers = { 'Content-Type': 'application/json' };
        if (authToken) headers['Authorization'] = `Bearer ${authToken}`;

        try {
            const response = await fetch(`${API_BASE}${endpoint}`, {
                method, headers, body: data ? JSON.stringify(data) : null
            });

            const responseText = await response.text();
            let responseData;
            
            try {
                responseData = JSON.parse(responseText);
            } catch (e) {
                console.error('Response was not JSON:', responseText);
                throw new Error(`Server returned invalid response: ${response.status}`);
            }

            if (!response.ok) {
                const errorMessage = responseData.error || responseData.message || responseData.errors || 'Request failed';
                console.error('API Error:', { status: response.status, data: responseData });
                throw new Error(typeof errorMessage === 'string' ? errorMessage : JSON.stringify(errorMessage));
            }
            
            return responseData;
        } catch (error) {
            console.error('API Call Error:', error);
            throw error;
        }
    }

    async function loadCandidates() {
        try {
            candidates = await apiCall('/candidates');
            selectedVotes = {};
            renderCandidates();
        } catch (error) {
            showToast('Failed to load candidates', 'error');
        }
    }

    function renderCandidates() {
        const grid = document.getElementById('candidatesGrid');
        grid.innerHTML = '';

        for (const [sector, candidateList] of Object.entries(candidates)) {
            const sectorDiv = document.createElement('div');
            sectorDiv.className = 'bg-white rounded-xl shadow-md border overflow-hidden';
            sectorDiv.innerHTML = `
                <div class="bg-gray-50 px-5 py-3 border-b">
                    <h3 class="font-bold text-lg">${sector}</h3>
                    <p class="text-xs text-gray-500">Select one candidate</p>
                </div>
                <div class="p-4 space-y-3" id="sector-${sector.replace(/\s/g, '')}"></div>
            `;
            grid.appendChild(sectorDiv);

            const container = document.getElementById(`sector-${sector.replace(/\s/g, '')}`);
            candidateList.forEach(candidate => {
                const isSelected = selectedVotes[sector] === candidate.id;
                const card = document.createElement('div');
                card.className = `vote-card rounded-xl border p-4 ${isSelected ? 'selected-candidate' : ''}`;
                card.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-bold">${candidate.display_name}</h4>
                            <p class="text-sm text-gray-500">${candidate.sector || ''}</p>
                        </div>
                        <div class="w-6 h-6 rounded-full border-2 ${isSelected ? 'bg-[#8B0000] border-[#8B0000]' : 'border-gray-300'} flex items-center justify-center">
                            ${isSelected ? '<i class="fas fa-check text-white text-xs"></i>' : ''}
                        </div>
                    </div>
                `;
                card.onclick = () => {
                    selectedVotes[sector] = candidate.id;
                    renderCandidates();
                    updateSummary();
                    showToast(`Selected ${candidate.display_name} for ${sector}`);
                };
                container.appendChild(card);
            });
        }
        updateSummary();
    }

    function updateSummary() {
        const summaryDiv = document.getElementById('voteSummary');
        summaryDiv.innerHTML = '';
        for (const [sector, candidateId] of Object.entries(selectedVotes)) {
            let candidateName = 'Not selected';
            if (candidates[sector]) {
                const found = candidates[sector].find(c => c.id === candidateId);
                if (found) candidateName = found.display_name;
            }
            summaryDiv.innerHTML += `<div class="bg-gray-50 p-2 rounded"><span class="font-semibold text-[#8B0000]">${sector}:</span> ${candidateName}</div>`;
        }
    }

    async function castVote() {
        if (!currentVoter) return showToast('Please login first', 'error');
        if (currentVoter.has_voted) return showToast('You have already voted!', 'error');
        
        const votesArray = Object.entries(selectedVotes).map(([sector, candidate_id]) => ({ sector, candidate_id }));
        
        if (votesArray.length !== Object.keys(candidates).length) {
            return showToast('Please vote in all sectors', 'error');
        }
        
        if (!confirm('Cast your vote? This action is irreversible and recorded on blockchain.')) return;
        
        try {
            const result = await apiCall('/vote', 'POST', { votes: votesArray });
            
            // Send vote confirmation via EmailJS
            const candidateNames = Object.entries(selectedVotes).map(([sector, id]) => {
                const candidate = candidates[sector]?.find(c => c.id === id);
                return `${sector}: ${candidate?.display_name || 'Unknown'}`;
            }).join('\n');
            
            const emailParams = {
                to_email: currentVoter.email,
                to_name: currentVoter.full_name,
                vote_summary: candidateNames,
                transaction_hash: result.transaction_hash || 'Blockchain verified',
                voting_date: new Date().toLocaleString(),
                admission_number: currentVoter.voter_id,
                message: 'Your vote has been successfully recorded on the blockchain.',
                name: 'IUEA Voting System',
                email: currentVoter.email
            };
            
            await emailjs.send(
                'service_uixgfye',
                'Confirmation Receipt',
                emailParams
            );
            
            showToast('Vote cast successfully! Confirmation sent to your email.');
            document.getElementById('votingPage').classList.add('hidden');
            document.getElementById('confirmationPage').classList.remove('hidden');
            
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    async function login() {
        const voter_id = document.getElementById('loginVoterId').value;
        const password = document.getElementById('loginPassword').value;

        try {
            const result = await apiCall('/login', 'POST', { voter_id, password });
            authToken = result.token;
            localStorage.setItem('auth_token', authToken);
            currentVoter = result.voter;
            showToast(`Welcome back, ${currentVoter.full_name}!`);
            await loadCandidates();
            document.getElementById('voterName').innerText = currentVoter.full_name;
            document.getElementById('authPage').classList.add('hidden');
            document.getElementById('votingPage').classList.remove('hidden');
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    async function register() {
        const first_name = document.getElementById('regFirstName').value;
        const last_name = document.getElementById('regLastName').value;
        const voter_id = document.getElementById('regVoterId').value;
        const email = document.getElementById('regEmail').value;
        const password = document.getElementById('regPassword').value;
        const password_confirmation = document.getElementById('regConfirmPassword').value;

        if (password !== password_confirmation) {
            return showToast('Passwords do not match', 'error');
        }

        try {
            await apiCall('/register', 'POST', { first_name, last_name, voter_id, email, password, password_confirmation });
            showToast('Registration successful! Please login.');
            document.getElementById('showLoginBtn').click();
        } catch (error) {
            showToast(error.message, 'error');
        }
    }

    function logout() {
        authToken = null;
        localStorage.removeItem('auth_token');
        currentVoter = null;
        document.getElementById('authPage').classList.remove('hidden');
        document.getElementById('votingPage').classList.add('hidden');
        document.getElementById('confirmationPage').classList.add('hidden');
    }

    // Event Listeners
    document.getElementById('showLoginBtn').onclick = () => {
        document.getElementById('loginForm').classList.remove('hidden');
        document.getElementById('registerForm').classList.add('hidden');
        document.getElementById('forgotPasswordForm').classList.add('hidden');
        document.getElementById('showLoginBtn').classList.add('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
        document.getElementById('showRegisterBtn').classList.remove('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
        document.getElementById('showRegisterBtn').classList.add('text-gray-500');
    };

    document.getElementById('showRegisterBtn').onclick = () => {
        document.getElementById('loginForm').classList.add('hidden');
        document.getElementById('registerForm').classList.remove('hidden');
        document.getElementById('forgotPasswordForm').classList.add('hidden');
        document.getElementById('showRegisterBtn').classList.add('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
        document.getElementById('showLoginBtn').classList.remove('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
        document.getElementById('showLoginBtn').classList.add('text-gray-500');
    };

    document.getElementById('forgotPasswordBtn').onclick = () => {
        document.getElementById('loginForm').classList.add('hidden');
        document.getElementById('registerForm').classList.add('hidden');
        document.getElementById('forgotPasswordForm').classList.remove('hidden');
    };

    document.getElementById('backToLoginFromReset').onclick = () => {
        document.getElementById('showLoginBtn').click();
    };

    document.getElementById('loginSubmitBtn').onclick = login;
    document.getElementById('registerSubmitBtn').onclick = register;
    document.getElementById('castVoteBtn').onclick = castVote;
    document.getElementById('logoutBtn').onclick = logout;
    document.getElementById('newVoteBtn').onclick = () => {
        document.getElementById('confirmationPage').classList.add('hidden');
        document.getElementById('authPage').classList.remove('hidden');
    };

    document.getElementById('sendResetLinkBtn').onclick = async () => {
        const email = document.getElementById('resetEmail').value;
        
        if (!email) {
            showToast('Please enter your email address', 'error');
            return;
        }
        
        showToast('Sending reset link...');
        
        try {
            // First, call your Laravel API to generate the reset token
            const response = await fetch(`${API_BASE}/forgot-password`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Email not found');
            }
            
            // Now send the email via EmailJS
            const emailParams = {
                to_email: email,
                to_name: email.split('@')[0],
                reset_link: data.reset_link,
                message: `Click the link below to reset your password: ${data.reset_link}`
            };
            
            console.log('Sending email with params:', emailParams);
            
            const result = await emailjs.send(
                'service_uixgfye',
                'password_reset',
                emailParams
            );
            
            console.log('EmailJS response:', result);
            showToast('Password reset link sent to your email!');
            document.getElementById('showLoginBtn').click();
            
        } catch (error) {
            console.error('Error:', error);
            showToast(error.message || 'Failed to send reset link', 'error');
        }
    };

    // Check if already logged in
    if (authToken) {
        (async () => {
            try {
                currentVoter = await apiCall('/user');
                await loadCandidates();
                document.getElementById('voterName').innerText = currentVoter.full_name;
                document.getElementById('authPage').classList.add('hidden');
                document.getElementById('votingPage').classList.remove('hidden');
            } catch {
                logout();
            }
        })();
    }
</script>

<script>
// Initialize EmailJS with your public key
emailjs.init("AKON5I-qdSpvPbsaj");
</script>
</body>

<script type="text/javascript">
    // Initialize EmailJS
    (function() {
        emailjs.init("AKON5I-qdSpvPbsaj");
        console.log("EmailJS initialized");
    })();
</script>

</html>