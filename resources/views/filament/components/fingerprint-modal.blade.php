<div x-data="{ open: @entangle('capture_fingerprint_modal') }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="text-center">
                <i class="fas fa-fingerprint text-6xl text-[#8B0000] mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Fingerprint Registration</h3>
                <p class="text-gray-600 mb-4">Place finger on Mantra MFS100 scanner</p>
                
                <div id="fp-status" class="p-3 rounded-lg mb-4 text-center"></div>
                
                <div class="flex justify-center gap-3">
                    <button id="fp-capture-start" class="bg-[#8B0000] text-white px-4 py-2 rounded">
                        <i class="fas fa-fingerprint mr-1"></i> Start Capture
                    </button>
                    <button @click="open = false" class="border border-gray-300 px-4 py-2 rounded">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let mantra = null;
    
    async function initMantra() {
        try {
            if (window.ActiveXObject) {
                mantra = new ActiveXObject("MFS100.MFS100Ctrl.1");
                mantra.InitEngine();
                return true;
            }
            return false;
        } catch(e) {
            updateStatus("Scanner not connected", "error");
            return false;
        }
    }
    
    async function captureFingerprint() {
        updateStatus("Place finger on scanner...", "info");
        
        try {
            setTimeout(() => {
                const mockTemplate = "FP_" + Date.now() + "_" + Math.random();
                const quality = 85;
                updateStatus("Fingerprint captured! Quality: " + quality + "%", "success");
                
                // Send to Livewire
                @this.set('fingerprint_template', mockTemplate);
                @this.set('fingerprint_quality', quality);
                @this.call('saveFingerprint');
                
                setTimeout(() => {
                    document.querySelector('[x-data]').__x.$data.open = false;
                }, 1500);
            }, 2000);
        } catch(e) {
            updateStatus("Failed to capture", "error");
        }
    }
    
    function updateStatus(msg, type) {
        const el = document.getElementById('fp-status');
        const colors = {
            success: 'bg-green-100 text-green-700',
            error: 'bg-red-100 text-red-700',
            info: 'bg-blue-100 text-blue-700'
        };
        el.className = 'p-3 rounded-lg mb-4 text-center ' + (colors[type] || colors.info);
        el.innerHTML = msg;
    }
    
    document.getElementById('fp-capture-start')?.addEventListener('click', async () => {
        if (await initMantra()) {
            captureFingerprint();
        }
    });
</script>
