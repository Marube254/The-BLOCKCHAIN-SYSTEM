<!DOCTYPE html>
<html>
<head>
    <title>Vote</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 p-10">

<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">

    <h1 class="text-2xl font-bold mb-6 text-center text-red-700">Voting Portal</h1>

    <!-- Step 1: Enter Voter ID -->
    <div id="step1">
        <label class="block mb-2 font-semibold">Enter Voter ID</label>
        <input id="voterId" type="text" class="border p-2 rounded w-full mb-4" placeholder="e.g. V001">

        <button onclick="identifyVoter()"
                class="bg-red-600 text-white px-4 py-2 rounded w-full">
            Continue
        </button>

        <p id="step1Message" class="mt-3 text-red-600"></p>
    </div>

    <!-- Step 2: Fingerprint Scan + Voting -->
    <div id="step2" class="hidden">
        <h2 class="text-lg font-semibold mb-4">Scan fingerprint to continue</h2>

        <button onclick="captureFingerprint()"
                class="bg-blue-600 text-white px-4 py-2 rounded w-full">
            Scan Fingerprint
        </button>

        <p id="fpStatus" class="mt-3 text-gray-700"></p>

        <div id="voteSection" class="hidden mt-5">
            <h3 class="font-bold mb-3">Select Your Candidates</h3>

            <!-- dynamic candidate list will be inserted here -->
            <div id="candidateList"></div>

            <button onclick="submitVote()"
                    class="mt-5 bg-green-600 text-white px-4 py-2 rounded w-full">
                Submit Vote
            </button>
        </div>
    </div>

</div>

<script>

function identifyVoter() {
    $.post('/vote/identify', {
        voter_id: $('#voterId').val(),
        _token: '{{ csrf_token() }}'
    })
    .done(function(res) {
        $('#step1').hide();
        $('#step2').show();
    })
    .fail(function(err) {
        $('#step1Message').text(err.responseJSON?.error || 'Cannot identify voter.');
    });
}

function captureFingerprint() {
    // Replace THIS with your scanner API event
    let fp = prompt("Scan fingerprint and paste value:");

    if (!fp) return;

    $('#fpStatus').text("Fingerprint captured.");

    // Load candidates from admin database
    $.get('/api/candidates', function(list) {
        let html = '';
        list.forEach(c => {
            html += `
                <div class="p-2 border mb-2">
                    <strong>${c.position}</strong><br>
                    ${c.name}
                    <input type="radio" name="${c.position}" value="${c.id}">
                </div>
            `;
        });
        $('#candidateList').html(html);
        $('#voteSection').show();
    });

    window.fingerprintData = fp;
}

function submitVote() {
    let voteData = {};

    $('input[type=radio]:checked').each(function() {
        voteData[$(this).attr('name')] = $(this).val();
    });

    $.post('/vote/submit', {
        fingerprint_data: window.fingerprintData,
        votes: voteData,
        _token: '{{ csrf_token() }}'
    })
    .done(() => {
        alert("Vote submitted!");
        window.location.reload();
    })
    .fail(err => {
        alert(err.responseJSON?.error || 'Failed to submit vote');
    });
}

</script>
</body>
</html>
