<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vote Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; border-top: 5px solid #8B0000;">
        <h2 style="color: #8B0000;">IUEA Voting System</h2>
        <h3>Thank You for Voting, {{ $voter->first_name }} {{ $voter->last_name }}!</h3>
        <p>Your vote has been successfully recorded on the blockchain.</p>

        <div style="background: #f8f8f8; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h4 style="margin-top: 0;">Your Vote Summary:</h4>
            @foreach($votes as $vote)
                <p><strong>{{ $vote['sector'] }}:</strong> {{ $vote['candidate_name'] }}</p>
            @endforeach
        </div>

        <p><strong>Transaction Hash:</strong> <code style="background: #eee; padding: 2px 5px;">{{ $votes[0]['transaction_hash'] ?? 'N/A' }}</code></p>
        <p><strong>Date & Time:</strong> {{ now()->format('F j, Y, g:i a') }}</p>

        <hr style="margin: 20px 0;">
        <p style="color: #666; font-size: 12px;">This is an automated confirmation. Your vote is immutable and securely stored on the blockchain.</p>
    </div>
</body>
</html>