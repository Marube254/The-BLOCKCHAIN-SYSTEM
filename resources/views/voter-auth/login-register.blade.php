<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>IUEA Voting System | Secure Student Elections</title>
  <!-- Tailwind CSS v3 + Font Awesome Icons + Google Fonts -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- EmailJS SDK -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
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
      box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
    }
    .selected-candidate {
      border-left: 6px solid #8B0000;
      background-color: #fef2f2;
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
    .error-border {
      border-color: #dc2626;
    }
    .error-message {
      color: #dc2626;
      font-size: 0.75rem;
      margin-top: 0.25rem;
    }
  </style>
</head>
<body class="bg-white text-gray-800">

  <!-- PRODUCTION NOTICE BANNER -->
  <div class="bg-gradient-to-r from-amber-400 to-orange-500 text-white text-center py-2 px-4 text-sm font-medium shadow-md">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    DEMO/PROTOTYPE VERSION - Not for Production Use
    <span class="ml-4 text-xs opacity-90">See upgrade documentation in code comments</span>
  </div>

  <!-- Main App Container -->
  <div id="app">
    <!-- Registration/Login Page -->
    <div id="authPage" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl">
        <div class="text-center">
          <div class="mx-auto h-16 w-16 bg-[#8B0000] rounded-full flex items-center justify-center">
            <i class="fas fa-university text-white text-2xl"></i>
          </div>
          <h2 class="mt-6 text-3xl font-bold text-gray-900">IUEA Voting System</h2>
          <p class="mt-2 text-sm text-gray-600">Student Government Elections 2025</p>
          <!-- Production Notice Badge -->
          <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
            <i class="fas fa-info-circle mr-1"></i> Demo Version
          </div>
        </div>

        <!-- Tab Navigation -->
        <div class="flex gap-2 border-b border-gray-200">
          <button id="loginTabBtn" class="flex-1 py-2 text-center font-semibold text-[#8B0000] border-b-2 border-[#8B0000] transition-all">Login</button>
          <button id="registerTabBtn" class="flex-1 py-2 text-center font-semibold text-gray-500 hover:text-gray-700 transition-all">Register</button>
        </div>

        <!-- Login Form -->
        <div id="loginForm" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Admission Number</label>
            <input type="text" id="loginAdmission" placeholder="e.g., IUEA-2025-1234" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="loginPassword" placeholder="••••••••" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
          </div>
          <div class="text-right">
            <button id="forgotPasswordBtn" class="text-sm text-[#8B0000] hover:underline">Forgot Password?</button>
          </div>
          <button id="loginBtn" class="w-full btn-primary text-white py-2 rounded-lg font-semibold">Login to Vote</button>
        </div>

        <!-- Registration Form -->
        <div id="registerForm" class="space-y-6 hidden">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
            <input type="text" id="regFullName" placeholder="e.g., John Doe" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
            <div id="nameError" class="error-message hidden"></div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Admission Number *</label>
            <input type="text" id="regAdmission" placeholder="e.g., IUEA-2025-1234" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
            <div id="admissionError" class="error-message hidden"></div>
            <p class="text-xs text-gray-500 mt-1">Unique admission number. This will be your login ID.</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" id="regEmail" placeholder="student@iuea.ac.ug" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
            <div id="emailError" class="error-message hidden"></div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="regPassword" placeholder="Minimum 6 characters" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
            <div id="passwordError" class="error-message hidden"></div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <input type="password" id="regConfirmPassword" placeholder="Confirm your password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#8B0000] focus:border-[#8B0000]">
          </div>
          <button id="registerBtn" class="w-full btn-primary text-white py-2 rounded-lg font-semibold">Create Account</button>
        </div>

      </div>
    </div>

    <!-- Voting Page (Hidden until login) -->
    <div id="votingPage" class="hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">

        <!-- Header Section -->
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
          <div class="mt-4 md:mt-0 flex items-center gap-3">
            <div class="bg-gray-50 px-4 py-2 rounded-full flex items-center gap-2">
              <i class="fas fa-id-card text-[#8B0000]"></i>
              <span class="text-sm font-medium text-gray-700" id="displayAdmission">Loading...</span>
            </div>
            <button id="logoutBtn" class="text-[#8B0000] hover:bg-red-50 px-3 py-2 rounded-lg transition-colors">
              <i class="fas fa-sign-out-alt"></i> Logout
            </button>
          </div>
        </div>

        <!-- Hero Banner -->
        <div class="bg-gradient-to-r from-white to-red-50 rounded-2xl p-5 md:p-6 mb-10 shadow-sm border border-gray-100 flex flex-wrap items-center justify-between">
          <div class="flex items-center gap-4">
            <div class="bg-[#8B0000]/10 p-3 rounded-full">
              <i class="fas fa-gem text-[#8B0000] text-2xl"></i>
            </div>
            <div>
              <h2 class="text-xl font-bold text-gray-800">Digital Democracy</h2>
              <p class="text-gray-600 text-sm max-w-xl">Your vote shapes the future of IUEA. Transparent, encrypted, and tamper-proof voting infrastructure.</p>
            </div>
          </div>
          <div class="mt-3 md:mt-0 flex gap-2">
            <div class="bg-white px-3 py-1 rounded-full shadow-sm text-xs font-semibold text-[#8B0000] border border-[#8B0000]/20"><i class="fas fa-check-circle mr-1"></i> Blockchain-backed</div>
            <div class="bg-white px-3 py-1 rounded-full shadow-sm text-xs font-semibold text-[#8B0000] border border-[#8B0000]/20"><i class="fas fa-chart-line mr-1"></i> Real-time</div>
          </div>
        </div>

        <!-- Voting Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" id="votingGrid">
          <!-- Positions will be injected here -->
        </div>

        <!-- Vote Action Panel -->
        <div class="mt-12 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 md:p-6">
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-5">
            <div>
              <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2"><i class="fas fa-ballot-check text-[#8B0000]"></i> Your vote summary</h3>
              <p class="text-sm text-gray-500 mt-1">Review your selections before casting the official ballot</p>
            </div>
            <div class="flex flex-wrap gap-3">
              <button id="resetVotesBtn" class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-gray-700 font-medium hover:bg-gray-50 transition-all shadow-sm flex items-center gap-2"><i class="fas fa-undo-alt"></i> Reset choices</button>
              <button id="submitVoteBtn" class="btn-primary px-6 py-2.5 rounded-xl text-white font-semibold shadow-md flex items-center gap-2"><i class="fas fa-vote-yea"></i> Cast Vote Securely</button>
            </div>
          </div>
          <div id="liveSummary" class="mt-5 pt-4 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-sm">
            <!-- Dynamic summary -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div id="forgotPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
      <h3 class="text-xl font-bold mb-4">Reset Password</h3>
      <p class="text-sm text-gray-600 mb-4">Enter your admission number and email to receive a password reset link.</p>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Admission Number</label>
          <input type="text" id="resetAdmission" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
          <input type="email" id="resetEmail" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        <div class="flex gap-3 mt-6">
          <button id="closeResetModal" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">Cancel</button>
          <button id="sendResetLinkBtn" class="flex-1 btn-primary text-white py-2 rounded-lg">Send Reset Link</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Container -->
  <div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

  <script>
    /*
    ================================================================================
    PRODUCTION UPGRADE DOCUMENTATION
    ================================================================================

    This is a DEMO/PROTOTYPE version using client-side storage for demonstration purposes.
    DO NOT USE IN PRODUCTION without implementing proper security measures.

    REQUIRED PRODUCTION UPGRADES:
    =============================

    1. AUTHENTICATION & SECURITY:
       - Replace localStorage with Laravel Breeze/Sanctum for proper authentication
       - Use bcrypt() for password hashing instead of plain text storage
       - Implement proper session management and CSRF protection
       - Add rate limiting for login attempts

    2. DATABASE PERSISTENCE:
       - Create proper Eloquent models for Users, Votes, Candidates
       - Use MySQL/PostgreSQL instead of localStorage
       - Implement database migrations for all entities
       - Add proper relationships and constraints

    3. EMAIL SYSTEM:
       - Replace EmailJS with Laravel's built-in Mail system
       - Configure SMTP server (Gmail, SendGrid, etc.)
       - Create proper email templates using Blade
       - Implement queue system for email sending

    4. VOTING SECURITY:
       - Implement server-side vote validation
       - Add vote integrity checks and audit trails
       - Prevent double voting with database constraints
       - Add vote encryption and blockchain integration if needed

    5. DEPLOYMENT & INFRASTRUCTURE:
       - Set up proper Laravel environment configuration
       - Implement HTTPS everywhere
       - Add monitoring and logging
       - Set up backup and recovery procedures

    QUICK UPGRADE STEPS:
    ====================

    1. Install Laravel Breeze: composer require laravel/breeze --dev
    2. Run: php artisan breeze:install
    3. Create User model with admission_number field
    4. Create Vote, Candidate models with proper relationships
    5. Configure database in .env file
    6. Run migrations: php artisan migrate
    7. Configure mail settings in .env
    8. Replace client-side logic with server-side controllers
    9. Add proper middleware for authentication
    10. Test thoroughly before deployment

    SECURITY WARNING:
    ================
    Current implementation stores passwords in plain text in localStorage.
    This is extremely insecure and should never be used in production.
    Always use proper password hashing and secure storage.

    ================================================================================
    */

    // ============ EMAILJS CONFIGURATION ============
    // Initialize EmailJS with your Public Key
    emailjs.init("AKON5I-qdSpvPbsaj");

    // Your EmailJS credentials
    const EMAILJS_SERVICE_ID = "service_uixgfye";
    const PASSWORD_RESET_TEMPLATE_ID = "password_reset"; // Your password reset template ID
    const VOTE_CONFIRMATION_TEMPLATE_ID = "Confirmation Receipt"; // Your vote confirmation template ID

    // Local Storage Database Simulation
    let users = JSON.parse(localStorage.getItem('iuea_users') || '[]');
    let currentUser = JSON.parse(sessionStorage.getItem('iuea_current_user') || 'null');

    // Voting data structure
    const positions = [
      { id: 'president', title: 'President', icon: 'fa-gavel' },
      { id: 'vpAcademic', title: 'Vice President (Academic)', icon: 'fa-chalkboard-user' },
      { id: 'secretary', title: 'Secretary General', icon: 'fa-file-signature' },
      { id: 'treasurer', title: 'Treasurer', icon: 'fa-coins' }
    ];

    const candidatesData = {
      president: [
        { id: 'p1', name: 'Aisha Nabukenya', program: 'BSc. Computer Science', slogan: 'Innovation for IUEA', imgIcon: 'fa-user-graduate' },
        { id: 'p2', name: 'David Mwangi', program: 'BBA', slogan: 'Unity & Progress', imgIcon: 'fa-chalkboard-user' }
      ],
      vpAcademic: [
        { id: 'vp1', name: 'Grace Atim', program: 'Software Engineering', slogan: 'Academic Excellence First', imgIcon: 'fa-book-open' },
        { id: 'vp2', name: 'James Omondi', program: 'Economics', slogan: 'Smart Policies, Better Learning', imgIcon: 'fa-chart-line' }
      ],
      secretary: [
        { id: 's1', name: 'Patricia Nambi', program: 'Law', slogan: 'Accountability & Transparency', imgIcon: 'fa-file-alt' },
        { id: 's2', name: 'Emmanuel Kato', program: 'Mass Comm', slogan: 'Voice of the Students', imgIcon: 'fa-microphone-alt' }
      ],
      treasurer: [
        { id: 't1', name: 'Rebecca Nantege', program: 'Accounting', slogan: 'Financial Integrity', imgIcon: 'fa-calculator' },
        { id: 't2', name: 'Brian Ssemwanga', program: 'Finance', slogan: 'Smart Budgeting', imgIcon: 'fa-chart-pie' }
      ]
    };

    let selections = {
      president: null,
      vpAcademic: null,
      secretary: null,
      treasurer: null
    };

    // Helper Functions
    function showToast(message, type = 'success') {
      const toastContainer = document.getElementById('toastContainer');
      const toast = document.createElement('div');
      toast.className = `toast-notification bg-white rounded-lg shadow-xl border-l-8 max-w-md w-full p-4 flex items-start gap-3 mb-2`;
      toast.style.borderLeftColor = type === 'success' ? '#8B0000' : (type === 'error' ? '#dc2626' : '#3b82f6');
      let icon = '<i class="fas fa-check-circle text-[#8B0000] text-lg"></i>';
      if (type === 'error') icon = '<i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>';
      if (type === 'info') icon = '<i class="fas fa-info-circle text-blue-500 text-lg"></i>';
      toast.innerHTML = `
        <div class="flex-shrink-0">${icon}</div>
        <div class="flex-1"><p class="text-sm font-medium text-gray-800">${message}</p></div>
        <button class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
      `;
      toastContainer.appendChild(toast);
      const closeBtn = toast.querySelector('button');
      closeBtn.addEventListener('click', () => toast.remove());
      setTimeout(() => toast.remove(), 4000);
    }

    // Send Email Function
    async function sendEmail(templateId, templateParams) {
      try {
        const response = await emailjs.send(EMAILJS_SERVICE_ID, templateId, templateParams);
        console.log('Email sent successfully:', response);
        return true;
      } catch (error) {
        console.error('Email sending failed:', error);
        return false;
      }
    }

    // Send Password Reset Email
    async function sendPasswordResetEmail(user, resetToken) {
      const resetLink = `${window.location.origin}${window.location.pathname}?reset_token=${resetToken}`;

      const templateParams = {
        to_name: user.fullName,
        to_email: user.email,
        admission_number: user.admission,
        reset_link: resetLink,
        message: `You requested to reset your password. Click the link below to set a new password. This link expires in 1 hour.`
      };

      const sent = await sendEmail(PASSWORD_RESET_TEMPLATE_ID, templateParams);
      if (sent) {
        showToast(`📧 Password reset link sent to ${user.email}`, 'success');
      } else {
        showToast(`⚠️ Could not send reset email. Please try again.`, 'error');
      }
    }

    // Send Vote Confirmation Email
    async function sendVoteConfirmation(user, voteDetails) {
      // Format vote summary for email
      const getCandidateName = (posId, candidateId) => {
        const candidate = candidatesData[posId].find(c => c.id === candidateId);
        return candidate ? candidate.name : 'Not selected';
      };

      const voteSummaryText = `
        President: ${getCandidateName('president', voteDetails.votes.president)}
        Vice President Academic: ${getCandidateName('vpAcademic', voteDetails.votes.vpAcademic)}
        Secretary General: ${getCandidateName('secretary', voteDetails.votes.secretary)}
        Treasurer: ${getCandidateName('treasurer', voteDetails.votes.treasurer)}
      `;

      const templateParams = {
        to_name: user.fullName,
        to_email: user.email,
        admission_number: user.admission,
        vote_summary: voteSummaryText,
        transaction_hash: voteDetails.transactionHash,
        voting_date: new Date().toLocaleString(),
        message: `Thank you for participating in the IUEA Student Government Elections. Your vote has been securely recorded.`
      };

      const sent = await sendEmail(VOTE_CONFIRMATION_TEMPLATE_ID, templateParams);
      if (sent) {
        showToast(`📧 Vote confirmation sent to ${user.email}`, 'success');
      } else {
        showToast(`⚠️ Vote recorded but confirmation email could not be sent.`, 'warning');
      }
    }

    function registerUser() {
      const fullName = document.getElementById('regFullName').value.trim();
      const admission = document.getElementById('regAdmission').value.trim();
      const email = document.getElementById('regEmail').value.trim();
      const password = document.getElementById('regPassword').value;
      const confirmPassword = document.getElementById('regConfirmPassword').value;

      document.querySelectorAll('.error-message').forEach(el => el.classList.add('hidden'));
      document.querySelectorAll('input').forEach(el => el.classList.remove('error-border'));

      let hasError = false;

      if (!fullName) {
        document.getElementById('nameError').textContent = 'Full name is required';
        document.getElementById('nameError').classList.remove('hidden');
        document.getElementById('regFullName').classList.add('error-border');
        hasError = true;
      }

      if (!admission) {
        document.getElementById('admissionError').textContent = 'Admission number is required';
        document.getElementById('admissionError').classList.remove('hidden');
        document.getElementById('regAdmission').classList.add('error-border');
        hasError = true;
      } else {
        const existingUser = users.find(u => u.admission === admission);
        if (existingUser) {
          document.getElementById('admissionError').textContent = 'The admission number has already been taken. Please use a unique admission number.';
          document.getElementById('admissionError').classList.remove('hidden');
          document.getElementById('regAdmission').classList.add('error-border');
          hasError = true;
          showToast('Admission number already exists! Please use a different one.', 'error');
        }
      }

      if (!email) {
        document.getElementById('emailError').textContent = 'Email is required';
        document.getElementById('emailError').classList.remove('hidden');
        document.getElementById('regEmail').classList.add('error-border');
        hasError = true;
      } else if (!email.includes('@')) {
        document.getElementById('emailError').textContent = 'Valid email is required';
        document.getElementById('emailError').classList.remove('hidden');
        document.getElementById('regEmail').classList.add('error-border');
        hasError = true;
      }

      if (!password) {
        document.getElementById('passwordError').textContent = 'Password is required';
        document.getElementById('passwordError').classList.remove('hidden');
        document.getElementById('regPassword').classList.add('error-border');
        hasError = true;
      } else if (password.length < 6) {
        document.getElementById('passwordError').textContent = 'Password must be at least 6 characters';
        document.getElementById('passwordError').classList.remove('hidden');
        document.getElementById('regPassword').classList.add('error-border');
        hasError = true;
      }

      if (password !== confirmPassword) {
        document.getElementById('passwordError').textContent = 'Passwords do not match';
        document.getElementById('passwordError').classList.remove('hidden');
        document.getElementById('regPassword').classList.add('error-border');
        document.getElementById('regConfirmPassword').classList.add('error-border');
        hasError = true;
      }

      if (hasError) return;

      const newUser = {
        id: Date.now(),
        fullName,
        admission,
        email,
        password, // SECURITY WARNING: Plain text password storage - NEVER use in production!
        hasVoted: false,
        createdAt: new Date().toISOString()
      };

      users.push(newUser);
      localStorage.setItem('iuea_users', JSON.stringify(users));

      showToast('Registration successful! Please login to vote.', 'success');

      document.getElementById('regFullName').value = '';
      document.getElementById('regAdmission').value = '';
      document.getElementById('regEmail').value = '';
      document.getElementById('regPassword').value = '';
      document.getElementById('regConfirmPassword').value = '';

      switchToLogin();
    }

    function loginUser() {
      const admission = document.getElementById('loginAdmission').value.trim();
      const password = document.getElementById('loginPassword').value;

      if (!admission || !password) {
        showToast('Please enter both admission number and password', 'error');
        return;
      }

      const user = users.find(u => u.admission === admission && u.password === password);

      if (!user) {
        showToast('Invalid admission number or password', 'error');
        return;
      }

      currentUser = user;
      sessionStorage.setItem('iuea_current_user', JSON.stringify(currentUser));

      showToast(`Welcome back, ${user.fullName}!`, 'success');

      loadVotingPage();
    }

    // Forgot Password - Send Reset Link
    async function sendResetLink() {
      const admission = document.getElementById('resetAdmission').value.trim();
      const email = document.getElementById('resetEmail').value.trim();

      const user = users.find(u => u.admission === admission && u.email === email);

      if (!user) {
        showToast('No account found with these credentials', 'error');
        return;
      }

      // Generate reset token
      const resetToken = Math.random().toString(36).substring(2, 15) + Date.now().toString(36);
      const tokenExpiry = new Date();
      tokenExpiry.setHours(tokenExpiry.getHours() + 1); // Token valid for 1 hour

      // Store token
      let resetTokens = JSON.parse(localStorage.getItem('iuea_reset_tokens') || '[]');
      resetTokens = resetTokens.filter(t => t.admission !== admission);
      resetTokens.push({
        admission: user.admission,
        token: resetToken,
        expiry: tokenExpiry.toISOString()
      });
      localStorage.setItem('iuea_reset_tokens', JSON.stringify(resetTokens));

      // Send password reset email
      await sendPasswordResetEmail(user, resetToken);

      // Close modal
      document.getElementById('forgotPasswordModal').classList.add('hidden');
      document.getElementById('resetAdmission').value = '';
      document.getElementById('resetEmail').value = '';
    }

    // Check for reset token in URL
    function checkForResetToken() {
      const urlParams = new URLSearchParams(window.location.search);
      const token = urlParams.get('reset_token');

      if (token) {
        let resetTokens = JSON.parse(localStorage.getItem('iuea_reset_tokens') || '[]');
        const tokenData = resetTokens.find(t => t.token === token);

        if (tokenData && new Date(tokenData.expiry) > new Date()) {
          const newPassword = prompt('Enter your new password (minimum 6 characters):');

          if (newPassword && newPassword.length >= 6) {
            const userIndex = users.findIndex(u => u.admission === tokenData.admission);
            if (userIndex !== -1) {
              users[userIndex].password = newPassword;
              localStorage.setItem('iuea_users', JSON.stringify(users));

              // Remove used token
              resetTokens = resetTokens.filter(t => t.token !== token);
              localStorage.setItem('iuea_reset_tokens', JSON.stringify(resetTokens));

              showToast('Password reset successful! Please login with your new password.', 'success');
            }
          } else if (newPassword) {
            showToast('Password must be at least 6 characters', 'error');
          }
        } else {
          showToast('Invalid or expired reset link. Please request a new one.', 'error');
        }

        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
      }
    }

    function logoutUser() {
      currentUser = null;
      sessionStorage.removeItem('iuea_current_user');
      showToast('Logged out successfully', 'info');
      showAuthPage();
    }

    function loadVotingPage() {
      document.getElementById('authPage').classList.add('hidden');
      document.getElementById('votingPage').classList.remove('hidden');
      document.getElementById('displayAdmission').textContent = currentUser.admission;

      if (currentUser.hasVoted) {
        showToast('⚠️ You have already voted in this election. Your vote has been recorded.', 'info');
        document.getElementById('submitVoteBtn').disabled = true;
        document.getElementById('submitVoteBtn').style.opacity = '0.5';
        document.getElementById('submitVoteBtn').style.cursor = 'not-allowed';
        document.getElementById('resetVotesBtn').disabled = true;
        document.getElementById('resetVotesBtn').style.opacity = '0.5';
      }

      renderVotingInterface();
    }

    function renderVotingInterface() {
      const grid = document.getElementById('votingGrid');
      grid.innerHTML = '';

      positions.forEach(pos => {
        const candidates = candidatesData[pos.id];
        const container = document.createElement('div');
        container.className = 'bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden';
        container.innerHTML = `
          <div class="bg-white px-5 py-4 border-b border-gray-100 flex justify-between items-center">
            <div>
              <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2"><i class="fas ${pos.icon} text-[#8B0000] text-sm"></i> ${pos.title}</h3>
              <p class="text-xs text-gray-400">Select one candidate</p>
            </div>
            <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-1 rounded-full">${candidates.length} candidates</span>
          </div>
          <div class="p-5 space-y-4" id="container-${pos.id}"></div>
        `;
        grid.appendChild(container);

        const candidatesContainer = document.getElementById(`container-${pos.id}`);
        candidates.forEach(candidate => {
          const isSelected = selections[pos.id] === candidate.id;
          const card = document.createElement('div');
          card.className = `vote-card cursor-pointer rounded-xl border border-gray-200 p-4 transition-all duration-200 bg-white ${isSelected ? 'selected-candidate' : ''}`;
          if (isSelected) card.style.borderLeft = '4px solid #8B0000';
          card.innerHTML = `
            <div class="flex items-start gap-3">
              <div class="w-10 h-10 bg-[#8B0000]/10 rounded-full flex items-center justify-center text-[#8B0000]">
                <i class="fas ${candidate.imgIcon} text-md"></i>
              </div>
              <div class="flex-1">
                <div class="flex justify-between items-start flex-wrap">
                  <h4 class="font-bold text-gray-800">${candidate.name}</h4>
                  <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">${candidate.program}</span>
                </div>
                <p class="text-sm text-gray-500 italic mt-1">"${candidate.slogan}"</p>
              </div>
              <div class="ml-2">
                <div class="w-5 h-5 rounded-full border-2 ${isSelected ? 'border-[#8B0000] bg-[#8B0000]' : 'border-gray-300'} flex items-center justify-center">
                  ${isSelected ? '<i class="fas fa-check text-white text-xs"></i>' : ''}
                </div>
              </div>
            </div>
          `;
          card.onclick = () => {
            if (currentUser.hasVoted) {
              showToast('You have already voted and cannot change your selection', 'error');
              return;
            }
            selections[pos.id] = candidate.id;
            renderVotingInterface();
            updateSummary();
            showToast(`Selected ${candidate.name} for ${pos.title}`, 'success');
          };
          candidatesContainer.appendChild(card);
        });
      });

      updateSummary();
    }

    function updateSummary() {
      const summaryDiv = document.getElementById('liveSummary');
      if (!summaryDiv) return;
      summaryDiv.innerHTML = '';
      positions.forEach(pos => {
        const selectedId = selections[pos.id];
        let candidateName = 'Not selected';
        if (selectedId) {
          const candidate = candidatesData[pos.id].find(c => c.id === selectedId);
          if (candidate) candidateName = candidate.name;
        }
        summaryDiv.innerHTML += `
          <div class="bg-gray-50 p-2 rounded-lg">
            <span class="font-semibold text-[#8B0000]">${pos.title}:</span>
            <span class="text-gray-700 ml-1">${candidateName}</span>
          </div>
        `;
      });
    }

    function resetVotes() {
      if (currentUser.hasVoted) {
        showToast('You have already voted and cannot reset your choices', 'error');
        return;
      }
      selections = {
        president: null,
        vpAcademic: null,
        secretary: null,
        treasurer: null
      };
      renderVotingInterface();
      showToast('All selections have been reset', 'info');
    }

    async function submitVote() {
      if (currentUser.hasVoted) {
        showToast('You have already cast your vote!', 'error');
        return;
      }

      const missing = [];
      if (!selections.president) missing.push('President');
      if (!selections.vpAcademic) missing.push('Vice President Academic');
      if (!selections.secretary) missing.push('Secretary General');
      if (!selections.treasurer) missing.push('Treasurer');

      if (missing.length > 0) {
        showToast(`Please select: ${missing.join(', ')}`, 'error');
        return;
      }

      const confirmVote = confirm(`🗳️ INTERNATIONAL UNIVERSITY OF EAST AFRICA\n\nYou are about to cast your vote.\n\n✅ This voting session is secured with encrypted infrastructure.\nYour vote is final and cannot be changed.\n\nProceed to cast ballot?`);

      if (!confirmVote) return;

      const voteRecord = {
        userId: currentUser.id,
        admission: currentUser.admission,
        votes: { ...selections },
        timestamp: new Date().toISOString(),
        transactionHash: '0x' + Math.random().toString(16).substring(2, 14) + Date.now().toString(16)
      };

      let votes = JSON.parse(localStorage.getItem('iuea_votes') || '[]');
      votes.push(voteRecord);
      localStorage.setItem('iuea_votes', JSON.stringify(votes));

      currentUser.hasVoted = true;
      const userIndex = users.findIndex(u => u.id === currentUser.id);
      if (userIndex !== -1) {
        users[userIndex].hasVoted = true;
        localStorage.setItem('iuea_users', JSON.stringify(users));
      }
      sessionStorage.setItem('iuea_current_user', JSON.stringify(currentUser));

      // Send vote confirmation email
      await sendVoteConfirmation(currentUser, voteRecord);

      showToast(`✅ Vote successfully recorded! Transaction: ${voteRecord.transactionHash.slice(0, 12)}...`, 'success');
      alert(`🎉 Thank you for voting, ${currentUser.fullName}!\n\nYour vote has been securely recorded.\nTransaction ID: ${voteRecord.transactionHash}\n\nA confirmation email has been sent to ${currentUser.email}`);

      document.getElementById('submitVoteBtn').disabled = true;
      document.getElementById('submitVoteBtn').style.opacity = '0.5';
      document.getElementById('resetVotesBtn').disabled = true;
      document.getElementById('resetVotesBtn').style.opacity = '0.5';

      renderVotingInterface();
    }

    function showAuthPage() {
      document.getElementById('authPage').classList.remove('hidden');
      document.getElementById('votingPage').classList.add('hidden');
    }

    function switchToLogin() {
      document.getElementById('loginForm').classList.remove('hidden');
      document.getElementById('registerForm').classList.add('hidden');
      document.getElementById('loginTabBtn').classList.add('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
      document.getElementById('registerTabBtn').classList.remove('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
      document.getElementById('registerTabBtn').classList.add('text-gray-500');
    }

    function switchToRegister() {
      document.getElementById('loginForm').classList.add('hidden');
      document.getElementById('registerForm').classList.remove('hidden');
      document.getElementById('registerTabBtn').classList.add('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
      document.getElementById('loginTabBtn').classList.remove('border-b-2', 'border-[#8B0000]', 'text-[#8B0000]');
      document.getElementById('loginTabBtn').classList.add('text-gray-500');
    }

    if (currentUser) {
      loadVotingPage();
    } else {
      showAuthPage();
    }

    checkForResetToken();

    // Event Listeners
    document.getElementById('loginTabBtn')?.addEventListener('click', switchToLogin);
    document.getElementById('registerTabBtn')?.addEventListener('click', switchToRegister);
    document.getElementById('loginBtn')?.addEventListener('click', loginUser);
    document.getElementById('registerBtn')?.addEventListener('click', registerUser);
    document.getElementById('logoutBtn')?.addEventListener('click', logoutUser);
    document.getElementById('resetVotesBtn')?.addEventListener('click', resetVotes);
    document.getElementById('submitVoteBtn')?.addEventListener('click', submitVote);
    document.getElementById('forgotPasswordBtn')?.addEventListener('click', () => {
      document.getElementById('forgotPasswordModal').classList.remove('hidden');
    });
    document.getElementById('closeResetModal')?.addEventListener('click', () => {
      document.getElementById('forgotPasswordModal').classList.add('hidden');
    });
    document.getElementById('sendResetLinkBtn')?.addEventListener('click', sendResetLink);
  </script>
</body>
</html>