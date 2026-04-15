<div id="fingerprintModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 10px; width: 400px; text-align: center;">
        <div style="margin-bottom: 20px;">
            <i class="fas fa-fingerprint" style="font-size: 60px; color: #8B0000;"></i>
        </div>
        <h3 id="fpTitle" style="font-size: 20px; margin-bottom: 15px;">Fingerprint Registration</h3>
        <p id="fpMessage" style="color: #666; margin-bottom: 20px;">Checking scanner availability...</p>
        <div id="fpStatus" style="padding: 10px; border-radius: 5px; margin-bottom: 20px; display: none;"></div>
        <button id="fpActionBtn" style="background: #8B0000; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Continue</button>
        <button id="fpCloseBtn" style="margin-left: 10px; padding: 10px 20px; border: 1px solid #ccc; background: white; border-radius: 5px; cursor: pointer;">Cancel</button>
    </div>
</div>

<script>
    let fpModal = document.getElementById('fingerprintModal');
    let fpTitle = document.getElementById('fpTitle');
    let fpMessage = document.getElementById('fpMessage');
    let fpStatus = document.getElementById('fpStatus');
    let fpActionBtn = document.getElementById('fpActionBtn');
    let fpCloseBtn = document.getElementById('fpCloseBtn');
    let currentStep = 'check';
    let credentialId = null;
    
    function showFingerprintModal() {
        fpModal.style.display = 'block';
        checkScanner();
    }
    
    function hideFingerprintModal() {
        fpModal.style.display = 'none';
        currentStep = 'check';
    }
    
    function updateStatus(message, type) {
        fpMessage.innerHTML = message;
        fpStatus.style.display = 'block';
        fpStatus.innerHTML = message;
        
        if (type === 'success') {
            fpStatus.style.background = '#d4edda';
            fpStatus.style.color = '#155724';
        } else if (type === 'error') {
            fpStatus.style.background = '#f8d7da';
            fpStatus.style.color = '#721c24';
        } else {
            fpStatus.style.background = '#d1ecf1';
            fpStatus.style.color = '#0c5460';
        }
    }
    
    async function checkScanner() {
        currentStep = 'check';
        fpTitle.innerHTML = 'Checking Scanner';
        updateStatus('Checking for built-in fingerprint scanner...', 'info');
        fpActionBtn.innerHTML = 'Checking...';
        fpActionBtn.disabled = true;
        
        try {
            if (!window.PublicKeyCredential) {
                updateStatus('❌ WebAuthn not supported. Please use Chrome or Edge browser.', 'error');
                fpActionBtn.innerHTML = 'Close';
                fpActionBtn.disabled = false;
                currentStep = 'failed';
                return;
            }
            
            const available = await PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable();
            
            if (available) {
                updateStatus('✅ Built-in fingerprint scanner detected!', 'success');
                fpTitle.innerHTML = 'Enroll Fingerprint';
                fpActionBtn.innerHTML = 'Start Enrollment';
                fpActionBtn.disabled = false;
                currentStep = 'ready';
            } else {
                updateStatus('❌ No fingerprint scanner found. Please set up Windows Hello Fingerprint.', 'error');
                fpActionBtn.innerHTML = 'Close';
                fpActionBtn.disabled = false;
                currentStep = 'failed';
            }
        } catch (error) {
            updateStatus('❌ Error: ' + error.message, 'error');
            fpActionBtn.innerHTML = 'Close';
            fpActionBtn.disabled = false;
            currentStep = 'failed';
        }
    }
    
    async function startEnrollment() {
        currentStep = 'enroll';
        fpTitle.innerHTML = 'Capture Fingerprint';
        updateStatus('🔴 Place your finger on the built-in scanner...', 'info');
        fpActionBtn.innerHTML = 'Capturing...';
        fpActionBtn.disabled = true;
        
        try {
            const challenge = new Uint8Array(32);
            window.crypto.getRandomValues(challenge);
            
            const publicKeyCredentialCreationOptions = {
                challenge: challenge,
                rp: { name: "IUEA Voting System", id: window.location.hostname },
                user: {
                    id: new TextEncoder().encode("voter-" + Date.now()),
                    name: "iuea-voter",
                    displayName: "IUEA Voter"
                },
                pubKeyCredParams: [
                    { type: "public-key", alg: -7 },
                    { type: "public-key", alg: -257 }
                ],
                authenticatorSelection: {
                    authenticatorAttachment: "platform",
                    userVerification: "required"
                },
                timeout: 60000,
                attestation: "none"
            };
            
            const credential = await navigator.credentials.create({
                publicKey: publicKeyCredentialCreationOptions
            });
            
            credentialId = btoa(String.fromCharCode(...new Uint8Array(credential.rawId)));
            
            updateStatus('✅ Fingerprint captured successfully!', 'success');
            fpTitle.innerHTML = 'Complete!';
            fpActionBtn.innerHTML = 'Save & Close';
            fpActionBtn.disabled = false;
            currentStep = 'complete';
            
            if (window.Livewire && typeof Livewire.find === 'function') {
                const components = Livewire.components.components;
                if (components && components.length > 0) {
                    const component = components[0];
                    component.set('fingerprint_template', credentialId);
                    component.set('fingerprint_quality', 95);
                    component.call('saveFingerprint');
                }
            }
        } catch (error) {
            updateStatus('❌ Failed: ' + error.message, 'error');
            fpActionBtn.innerHTML = 'Try Again';
            fpActionBtn.disabled = false;
            currentStep = 'ready';
        }
    }
    
    fpActionBtn.onclick = function() {
        if (currentStep === 'ready') {
            startEnrollment();
        } else if (currentStep === 'complete') {
            hideFingerprintModal();
        } else if (currentStep === 'failed') {
            hideFingerprintModal();
        } else if (currentStep === 'check') {
            hideFingerprintModal();
        }
    };
    
    fpCloseBtn.onclick = hideFingerprintModal;
</script>
