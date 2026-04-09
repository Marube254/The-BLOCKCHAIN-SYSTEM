<div class="p-6 bg-white rounded-lg shadow-md border border-gray-200">
    <!-- Debug: Fingerprint component loaded -->
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-2 rounded mb-4 text-sm">
        <strong>Debug:</strong> Fingerprint component loaded successfully!
    </div>

    <div class="text-center mb-6">
        <div class="text-6xl text-[#8B0000] mb-3">
            <i class="fas fa-fingerprint"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800">Fingerprint Registration</h3>
        <p class="text-sm text-gray-600 mt-1">Place your finger on the Mantra MFS100 scanner</p>
    </div>

    <!-- Status Messages -->
    <div id="fingerprint-status" class="text-center p-3 rounded-lg mb-4 bg-blue-50 text-blue-700">
        <span id="status-message"><i class="fas fa-circle text-blue-400 mr-2"></i>Ready to capture fingerprint</span>
    </div>

    <!-- Buttons -->
    <div class="flex flex-col gap-3">
        <button type="button" id="capture-fingerprint" 
                class="w-full px-4 py-2 rounded-lg text-white bg-[#8B0000] hover:bg-[#6a0000] transition font-medium">
            <i class="fas fa-fingerprint mr-2"></i> Capture Fingerprint
        </button>
        <button type="button" id="verify-fingerprint" 
                class="w-full px-4 py-2 rounded-lg border-2 border-[#8B0000] text-[#8B0000] hover:bg-red-50 transition font-medium">
            <i class="fas fa-check mr-2"></i> Verify
        </button>
    </div>

    <!-- Success Preview -->
    <div id="fingerprint-preview" class="mt-4 p-3 hidden bg-green-50 border border-green-300 rounded-lg text-center">
        <p class="text-green-700 text-sm">
            <i class="fas fa-check-circle text-green-600 mr-2"></i> Fingerprint captured successfully!
        </p>
    </div>

    <!-- Hidden input for storing template -->
    <input type="hidden" id="fingerprint_template_input" value="">
</div>

<script>
(function() {
    let mantraDevice = null;
    let capturedTemplate = null;
    let capturedQuality = null;

    function initMantra() {
        try {
            if (window.ActiveXObject) {
                mantraDevice = new ActiveXObject("MFS100.MFS100Ctrl.1");
                mantraDevice.InitEngine();
                console.log("✓ Mantra MFS100 device initialized successfully");
                updateStatus("Scanner ready. Place finger on device.", "success");
                return true;
            } else {
                console.log("ActiveX not available, fingerprint device disabled");
                updateStatus("Scanner not available (browser does not support ActiveX)", "warning");
                return false;
            }
        } catch (error) {
            console.error("✗ Mantra initialization error:", error.message);
            updateStatus("Scanner not detected. Please ensure Mantra MFS100 is connected.", "error");
            return false;
        }
    }

    function captureFingerprint() {
        if (!mantraDevice) {
            updateStatus("Scanner not initialized. Please refresh the page.", "error");
            return;
        }

        updateStatus("Capturing fingerprint... Please place your finger on the scanner.", "info");
        
        try {
            const quality = mantraDevice.GetQuality();
            const template = mantraDevice.GetTemplate();
            
            if (template && quality > 40) {
                capturedTemplate = template;
                capturedQuality = quality;
                document.getElementById('fingerprint_template_input').value = template;
                document.getElementById('fingerprint-preview').classList.remove('hidden');
                updateStatus(`Fingerprint captured successfully! Quality: ${quality}%`, "success");
                console.log("✓ Fingerprint captured with quality:", quality);
                
                // Update Livewire if available
                const wire = document.querySelector('[wire\\:id]');
                if (wire && window.Livewire) {
                    const component = Object.values(window.Livewire.all ? window.Livewire.all() : {})[0];
                    if (component) {
                        component.set('fingerprint_template', template);
                        component.set('fingerprint_quality', quality);
                        console.log("✓ Updated Livewire component");
                    }
                }
            } else {
                const actualQuality = quality || 0;
                updateStatus(`Poor fingerprint quality (${actualQuality}%). Please try again.`, "error");
                console.warn("✗ Low quality fingerprint:", actualQuality);
            }
        } catch (error) {
            console.error("✗ Capture error:", error.message);
            updateStatus("Failed to capture fingerprint. Please try again.", "error");
        }
    }

    function verifyFingerprint() {
        if (!capturedTemplate) {
            updateStatus("Please capture fingerprint first.", "error");
            return;
        }

        if (!mantraDevice) {
            updateStatus("Scanner not initialized.", "error");
            return;
        }

        updateStatus("Verifying fingerprint... Please place your finger on the scanner.", "info");
        
        try {
            const template = mantraDevice.GetTemplate();
            
            if (mantraDevice.MatchTemplate && template) {
                const isMatch = mantraDevice.MatchTemplate(capturedTemplate, template);
                
                if (isMatch) {
                    updateStatus("✓ Fingerprint verified successfully!", "success");
                    console.log("✓ Fingerprint verified");
                    
                    // Update Livewire
                    const component = Object.values(window.Livewire && window.Livewire.all ? window.Livewire.all() : {})[0];
                    if (component) {
                        component.set('fingerprint_verified', true);
                        console.log("✓ Set fingerprint_verified to true");
                    }
                } else {
                    updateStatus("Fingerprint does not match. Please try again.", "error");
                    console.warn("✗ Fingerprint mismatch");
                }
            } else {
                updateStatus("Could not read fingerprint. Please try again.", "error");
            }
        } catch (error) {
            console.error("✗ Verification error:", error.message);
            updateStatus("Verification failed. Please try again.", "error");
        }
    }

    function updateStatus(message, type = 'info') {
        const statusDiv = document.getElementById('fingerprint-status');
        const messageSpan = document.getElementById('status-message');
        
        messageSpan.innerHTML = message;
        statusDiv.className = 'text-center p-3 rounded-lg mb-4';
        
        const icons = {
            'success': 'fa-check-circle text-green-600',
            'error': 'fa-exclamation-circle text-red-600',
            'warning': 'fa-exclamation-triangle text-yellow-600',
            'info': 'fa-circle text-blue-400'
        };
        
        const colors = {
            'success': 'bg-green-50 text-green-700 border border-green-300',
            'error': 'bg-red-50 text-red-700 border border-red-300',
            'warning': 'bg-yellow-50 text-yellow-700 border border-yellow-300',
            'info': 'bg-blue-50 text-blue-700 border border-blue-300'
        };
        
        statusDiv.className = `text-center p-3 rounded-lg mb-4 ${colors[type] || colors['info']}`;
    }

    // Attach event listeners
    document.getElementById('capture-fingerprint').addEventListener('click', captureFingerprint);
    document.getElementById('verify-fingerprint').addEventListener('click', verifyFingerprint);

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        console.log("🔧 Initializing fingerprint scanner...");
        initMantra();
    });

    // Also try on window load
    window.addEventListener('load', function() {
        if (!mantraDevice) {
            console.log("🔧 Retrying fingerprint scanner initialization on window load...");
            initMantra();
        }
    });
})();
</script>

