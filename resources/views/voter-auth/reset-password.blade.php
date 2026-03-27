<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Reset Password | IUEA Voting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        .btn-primary {
            background-color: #8B0000;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background-color: #6a0000;
            transform: scale(0.98);
        }
        .input-focus:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #fff 0%, #fff8f5 100%);
        }
    </style>
</head>
<body class="bg-white text-gray-800">

<div class="min-h-screen flex items-center justify-center px-4 py-6">
    <div class="w-full max-w-md">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-[#8B0000] rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-university text-white text-2xl"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">IUEA <span class="text-[#8B0000]">VoteHub</span></h1>
            <p class="text-gray-600 text-sm mt-2">International University of East Africa • Reset Your Password</p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="hero-gradient rounded-lg p-4 mb-6 border border-gray-100">
                <p class="text-sm text-gray-700 flex items-start gap-2">
                    <i class="fas fa-lock text-[#8B0000] mt-0.5"></i>
                    <span>Create a <strong>new secure password</strong> for your voter account</span>
                </p>
            </div>

            <form id="resetPasswordForm" class="space-y-4">
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="your.email@iuea.ac.ug" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="At least 8 characters" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus outline-none" required minlength="8">
                        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePasswordVisibility('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your new password" class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus outline-none" required minlength="8">
                        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePasswordVisibility('password_confirmation')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full text-white py-3 rounded-lg font-semibold flex items-center justify-center gap-2 shadow-md">
                    <i class="fas fa-check-circle"></i> Reset Password
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    Remember your password? <a href="{{ route('voter.auth') }}" class="text-[#8B0000] font-semibold hover:underline">Login here</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-xs text-gray-500">
            <p class="flex items-center justify-center gap-1">
                <i class="fas fa-shield-alt text-[#8B0000]"></i>
                Secure password reset for IUEA voters
            </p>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

<script>
    const csrfToken = '{{ csrf_token() }}';

    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }

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
        
        toast.className = `${bgColor} rounded-lg shadow-lg border-l-4 max-w-md w-full p-4 flex items-start gap-3`;
        toast.style.borderLeftColor = borderColor;
        toast.innerHTML = `
            <div class="flex-shrink-0">${icon}</div>
            <div class="flex-1"><p class="text-sm font-medium text-gray-800">${message}</p></div>
            <button class="text-gray-400 hover:text-gray-600" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
        `;
        toastContainer.appendChild(toast);
        setTimeout(() => {
            if (toast.parentNode) toast.remove();
        }, 4000);
    }

    document.getElementById('resetPasswordForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const email = document.getElementById('email').value;
        const token = document.querySelector('input[name="token"]').value;

        if (password !== passwordConfirmation) {
            showToast('Passwords do not match!', 'error');
            return;
        }

        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Resetting...';

        try {
            const response = await fetch('{{ route("voter.reset-password") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    token,
                    email,
                    password,
                    password_confirmation: passwordConfirmation,
                }),
            });

            const data = await response.json();

            if (data.success) {
                showToast('✓ ' + data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                showToast(data.message, 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Reset Password';
        }
    });
</script>

</body>
</html>
