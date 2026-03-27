<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>IUEA Voting System | Cast Your Vote</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        .vote-card {
            transition: all 0.25s ease-in-out;
        }
        .vote-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1), 0 4px 8px -2px rgba(0, 0, 0, 0.05);
        }
        .selected-candidate {
            border-left: 6px solid #8B0000;
            background-color: #fef2f2;
            box-shadow: 0 4px 12px rgba(139, 0, 0, 0.08);
        }
        .toast-notification {
            animation: fadeInUp 0.3s ease forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .btn-primary {
            background-color: #8B0000;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background-color: #6a0000;
            transform: scale(0.98);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #fff 0%, #fff8f5 100%);
        }
    </style>
</head>
<body class="bg-white text-gray-800">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        
        <!-- Header Section with IUEA branding & dark red accent -->
        <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-5 mb-8">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-[#8B0000] rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-university text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-800">IUEA <span class="text-[#8B0000]">VoteHub</span></h1>
                    <p class="text-sm text-gray-500">International University of East Africa • Student Government Elections</p>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex items-center gap-4">
                <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-full">
                    <i class="fas fa-user-circle text-[#8B0000]"></i>
                    <span class="text-sm font-medium text-gray-700">{{ $voter->first_name }} {{ $voter->last_name }}</span>
                </div>
                <form id="logoutForm" method="POST" action="{{ route('voter.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition-all flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Hero / Info banner with value proposition: "Secure $5000 value voting ecosystem" -->
        <div class="hero-gradient rounded-2xl p-5 md:p-6 mb-10 shadow-sm border border-gray-100 flex flex-wrap items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-[#8B0000]/10 p-3 rounded-full">
                    <i class="fas fa-gem text-[#8B0000] text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Digital Democracy <span class="text-[#8B0000]">| $5,000 Value</span></h2>
                    <p class="text-gray-600 text-sm max-w-xl">Your vote shapes the future of IUEA. Transparent, encrypted, and tamper-proof voting infrastructure — empowering 5000+ students.</p>
                </div>
            </div>
            <div class="mt-3 md:mt-0 flex gap-2">
                <div class="bg-white px-3 py-1 rounded-full shadow-sm text-xs font-semibold text-[#8B0000] border border-[#8B0000]/20"><i class="fas fa-check-circle mr-1"></i> Blockchain-backed</div>
                <div class="bg-white px-3 py-1 rounded-full shadow-sm text-xs font-semibold text-[#8B0000] border border-[#8B0000]/20"><i class="fas fa-chart-line mr-1"></i> Real-time</div>
            </div>
        </div>

        <!-- Status check: Has voted or can vote -->
        @if($voter->has_voted)
            <div class="bg-yellow-50 rounded-xl p-5 mb-8 border border-yellow-200">
                <p class="text-yellow-800 flex items-start gap-2">
                    <i class="fas fa-exclamation-circle text-yellow-600 text-lg mt-0.5"></i>
                    <span><strong>Vote already cast:</strong> You have already participated in this election. Each voter can only vote once. Thank you for your participation!</span>
                </p>
            </div>
        @endif

        <!-- Voting Grid: 4 Positions with candidates (clean, white dominates) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- President -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden transition-all">
                <div class="bg-white px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2"><i class="fas fa-gavel text-[#8B0000] text-sm"></i> President</h3>
                        <p class="text-xs text-gray-400">Select one candidate</p>
                    </div>
                </div>
                <div class="p-5 space-y-4" id="presidentContainer"></div>
            </div>

            <!-- Vice President Academic -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-white px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2"><i class="fas fa-chalkboard-user text-[#8B0000] text-sm"></i> Vice President (Academic)</h3>
                        <p class="text-xs text-gray-400">Select one candidate</p>
                    </div>
                </div>
                <div class="p-5 space-y-4" id="vpAcademicContainer"></div>
            </div>

            <!-- Secretary General -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-white px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2"><i class="fas fa-file-signature text-[#8B0000] text-sm"></i> Secretary General</h3>
                        <p class="text-xs text-gray-400">Select one candidate</p>
                    </div>
                </div>
                <div class="p-5 space-y-4" id="secretaryContainer"></div>
            </div>

            <!-- Treasurer -->
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-white px-5 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2"><i class="fas fa-coins text-[#8B0000] text-sm"></i> Treasurer</h3>
                        <p class="text-xs text-gray-400">Select one candidate</p>
                    </div>
                </div>
                <div class="p-5 space-y-4" id="treasurerContainer"></div>
            </div>
        </div>

        <!-- Voter Action Panel: Cast Vote + Summary -->
        <div class="mt-12 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 md:p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-5">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2"><i class="fas fa-ballot-check text-[#8B0000]"></i> Your vote summary</h3>
                    <p class="text-sm text-gray-500 mt-1">Review your selections before casting the official ballot</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button id="resetVotesBtn" class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-gray-700 font-medium hover:bg-gray-50 transition-all shadow-sm flex items-center gap-2">
                        <i class="fas fa-undo-alt"></i> Reset choices
                    </button>
                    <button id="submitVoteBtn" class="btn-primary px-6 py-2.5 rounded-xl text-white font-semibold shadow-md flex items-center gap-2" {{ $voter->has_voted ? 'disabled' : '' }}>
                        <i class="fas fa-vote-yea"></i> Cast Vote Securely
                    </button>
                </div>
            </div>
            <!-- live selected summary chips -->
            <div id="liveSummary" class="mt-5 pt-4 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-sm">
                <div class="bg-gray-50 p-2 rounded-lg"><span class="font-semibold text-[#8B0000]">President:</span> <span id="summaryPres" class="text-gray-700">Not selected</span></div>
                <div class="bg-gray-50 p-2 rounded-lg"><span class="font-semibold text-[#8B0000]">VP Academic:</span> <span id="summaryVp" class="text-gray-700">Not selected</span></div>
                <div class="bg-gray-50 p-2 rounded-lg"><span class="font-semibold text-[#8B0000]">Secretary:</span> <span id="summarySec" class="text-gray-700">Not selected</span></div>
                <div class="bg-gray-50 p-2 rounded-lg"><span class="font-semibold text-[#8B0000]">Treasurer:</span> <span id="summaryTre" class="text-gray-700">Not selected</span></div>
            </div>
        </div>
    </div>

    <!-- Toast notification container (floating) -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

    <!-- Footer with university details and value assurance -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-gray-500 text-xs">
            <div class="flex gap-4 items-center">
                <i class="fas fa-shield-alt text-[#8B0000] text-sm"></i>
                <span>Secure end-to-end encrypted voting • $5,000 value infrastructure grant</span>
            </div>
            <div class="mt-2 md:mt-0">© 2025 International University of East Africa • Student Electoral Commission</div>
        </div>
    </footer>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        const hasVoted = {{ $voter->has_voted ? 'true' : 'false' }};
        
        // Positions configuration
        const positions = [
            { id: 'president', title: 'President', summaryId: 'summaryPres', containerId: 'presidentContainer' },
            { id: 'vpacademic', title: 'Vice President (Academic)', summaryId: 'summaryVp', containerId: 'vpAcademicContainer' },
            { id: 'secretary', title: 'Secretary General', summaryId: 'summarySec', containerId: 'secretaryContainer' },
            { id: 'treasurer', title: 'Treasurer', summaryId: 'summaryTre', containerId: 'treasurerContainer' }
        ];

        // Candidates data from backend (explicit per position)
        const candidatesData = {
            president: {!! json_encode($presidentCandidates) !!},
            vpacademic: {!! json_encode($vpAcademicCandidates) !!},
            secretary: {!! json_encode($secretaryCandidates) !!},
            treasurer: {!! json_encode($treasurerCandidates) !!}
        };

        // Store user selections
        let selections = {
            president: null,
            vpacademic: null,
            secretary: null,
            treasurer: null
        };

        // Helper to update UI summaries & highlight selected cards
        function updateAllSummariesAndHighlights() {
            for (let pos of positions) {
                const selectedId = selections[pos.id];
                const summarySpan = document.getElementById(pos.summaryId);
                let candidateName = 'Not selected';
                
                if (selectedId) {
                    const candidates = getCandidatesByPosition(pos.code);
                    const candidate = candidates.find(c => c.id === selectedId);
                    if (candidate) candidateName = candidate.display_name || (candidate.first_name + ' ' + candidate.last_name);
                }
                
                if (summarySpan) summarySpan.innerText = candidateName;
                
                // Update card highlight
                const container = document.getElementById(pos.containerId);
                if (container) {
                    const allCards = container.querySelectorAll('.vote-card');
                    allCards.forEach(card => {
                        card.classList.remove('selected-candidate');
                        card.style.borderLeft = '';
                    });
                    if (selectedId) {
                        const selectedCard = container.querySelector(`[data-candidate-id="${selectedId}"]`);
                        if (selectedCard) {
                            selectedCard.classList.add('selected-candidate');
                            selectedCard.style.borderLeft = '6px solid #8B0000';
                        }
                    }
                }
            }
        }

        // Get candidates by position id
        function getCandidatesByPosition(positionId) {
            return candidatesData[positionId] || [];
        }

        // Render all candidates for each position
        function renderAllCandidates() {
            for (let pos of positions) {
                const container = document.getElementById(pos.containerId);
                if (!container) continue;
                
                const candidatesList = getCandidatesByPosition(pos.code);
                container.innerHTML = '';
                
                candidatesList.forEach(candidate => {
                    const isSelected = (selections[pos.id] === candidate.id);
                    const cardDiv = document.createElement('div');
                    cardDiv.setAttribute('data-candidate-id', candidate.id);
                    cardDiv.setAttribute('data-position', pos.id);
                    cardDiv.className = `vote-card cursor-pointer rounded-xl border border-gray-200 p-4 transition-all duration-200 bg-white ${isSelected ? 'selected-candidate' : ''}`;
                    if (isSelected) cardDiv.style.borderLeft = '6px solid #8B0000';
                    
                    const displayName = candidate.display_name || (candidate.first_name + ' ' + candidate.last_name);
                    const photoPath = candidate.photo_filename ? `/candidate-photos/${candidate.photo_filename}` : null;
                    
                    cardDiv.innerHTML = `
                        <div class="flex items-start gap-3">
                            ${photoPath ? `<img src="${photoPath}" alt="${displayName}" class="w-12 h-12 rounded-full object-cover">` : `<div class="w-12 h-12 bg-[#8B0000]/10 rounded-full flex items-center justify-center text-[#8B0000]"><i class="fas fa-user text-lg"></i></div>`}
                            <div class="flex-1">
                                <div class="flex justify-between items-start flex-wrap">
                                    <h4 class="font-bold text-gray-800">${displayName}</h4>
                                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">${candidate.program || 'N/A'}</span>
                                </div>
                                ${candidate.manifesto ? `<p class="text-sm text-gray-500 italic mt-1">"${candidate.manifesto}"</p>` : ''}
                            </div>
                            <div class="ml-2">
                                <div class="w-5 h-5 rounded-full border-2 ${isSelected ? 'border-[#8B0000] bg-[#8B0000]' : 'border-gray-300'} flex items-center justify-center">
                                    ${isSelected ? '<i class="fas fa-check text-white text-xs"></i>' : ''}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    cardDiv.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (hasVoted) return;
                        selections[pos.id] = candidate.id;
                        renderAllCandidates();
                        updateAllSummariesAndHighlights();
                        showToast(`✓ You selected ${displayName} for ${pos.title}`, 'success');
                    });
                    container.appendChild(cardDiv);
                });
            }
        }

        // Reset all selections
        function resetAllSelections() {
            if (hasVoted) return;
            selections = {
                president: null,
                vpacademic: null,
                secretary: null,
                treasurer: null
            };
            renderAllCandidates();
            updateAllSummariesAndHighlights();
            showToast('All votes have been reset. You can now make new selections.', 'info');
        }

        // Toast manager
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            let bgColor = 'bg-green-50';
            let borderColor = '#8B0000';
            let icon = '<i class="fas fa-check-circle text-[#8B0000]"></i>';
            
            if (type === 'error') {
                bgColor = 'bg-red-50';
                borderColor = '#dc2626';
                icon = '<i class="fas fa-exclamation-circle text-red-600"></i>';
            } else if (type === 'info') {
                bgColor = 'bg-blue-50';
                borderColor = '#3b82f6';
                icon = '<i class="fas fa-info-circle text-blue-600"></i>';
            }
            
            toast.className = `toast-notification ${bgColor} rounded-lg shadow-lg border-l-4 max-w-md w-full p-4 flex items-start gap-3`;
            toast.style.borderLeftColor = borderColor;
            toast.innerHTML = `
                <div class="flex-shrink-0">${icon}</div>
                <div class="flex-1"><p class="text-sm font-medium text-gray-800">${message}</p></div>
                <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
            `;
            toastContainer.appendChild(toast);
            const closeBtn = toast.querySelector('button');
            closeBtn.addEventListener('click', () => toast.remove());
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
            }, 4000);
        }

        // Submit vote
        async function submitVote() {
            if (hasVoted) {
                showToast('You have already voted. Thank you for your participation!', 'info');
                return;
            }

            // Validate all positions selected
            const missing = [];
            if (!selections.president) missing.push('President');
            if (!selections.vpacademic) missing.push('Vice President Academic');
            if (!selections.secretary) missing.push('Secretary General');
            if (!selections.treasurer) missing.push('Treasurer');
            
            if (missing.length > 0) {
                showToast(`⚠️ Please complete your vote: ${missing.join(', ')} must be selected.`, 'error');
                return;
            }
            
            const votes = [
                { sector_code: 'PRES', candidate_id: selections.president },
                { sector_code: 'VP-AC', candidate_id: selections.vpacademic },
                { sector_code: 'SEC', candidate_id: selections.secretary },
                { sector_code: 'TREAS', candidate_id: selections.treasurer }
            ];

            const confirmVote = confirm('🗳️ INTERNATIONAL UNIVERSITY OF EAST AFRICA\n\nYou are about to cast your vote:\n\n✅ This voting session is secured with $5,000 value encrypted infrastructure.\nYour vote is final and cannot be changed.\n\nProceed to cast ballot?');
            
            if (!confirmVote) {
                showToast('Vote submission cancelled. Your selections remain.', 'info');
                return;
            }
            
            const submitBtn = document.getElementById('submitVoteBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

            try {
                const response = await fetch('{{ route("voter.submit-vote") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ votes }),
                });

                const data = await response.json();

                if (data.success) {
                    showToast(`✅ Vote cast! ${data.transaction_hash.slice(0, 12)}... | IUEA Electoral Commission`, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                showToast('Error submitting vote. Please try again.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-vote-yea"></i> Cast Vote Securely';
            }
        }

        // Logout handler
        document.getElementById('logoutBtn').addEventListener('click', async () => {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '{{ route("voter.logout") }}';
            }
        });

        // Event listeners
        document.getElementById('resetVotesBtn').addEventListener('click', resetAllSelections);
        document.getElementById('submitVoteBtn').addEventListener('click', submitVote);

        // Initialize
        renderAllCandidates();
        updateAllSummariesAndHighlights();
    </script>

</body>
</html>
