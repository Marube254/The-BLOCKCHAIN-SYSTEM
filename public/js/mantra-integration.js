// Mantra MFS100 Integration
class MantraFingerprint {
    constructor() {
        this.device = null;
        this.isInitialized = false;
        this.lastTemplate = null;
        this.lastQuality = null;
    }

    async init() {
        try {
            // Check if ActiveX is available (Internet Explorer/Edge legacy)
            if (window.ActiveXObject) {
                this.device = new ActiveXObject("MFS100.MFS100Ctrl.1");
                this.device.InitEngine();
                this.isInitialized = true;
                console.log("Mantra device initialized via ActiveX");
                return true;
            }
            
            // For modern browsers, use WebUSB (if supported)
            if (navigator.usb) {
                try {
                    const device = await navigator.usb.requestDevice({
                        filters: [{ vendorId: 0x1CBE }] // Mantra vendor ID
                    });
                    await device.open();
                    await device.claimInterface(0);
                    this.device = device;
                    this.isInitialized = true;
                    console.log("Mantra device initialized via WebUSB");
                    return true;
                } catch (usbError) {
                    console.warn("WebUSB not available:", usbError);
                }
            }
            
            console.warn("No compatible fingerprint scanner found");
            return false;
        } catch (error) {
            console.error("Fingerprint initialization failed:", error);
            return false;
        }
    }

    async capture() {
        if (!this.isInitialized) {
            throw new Error("Scanner not initialized");
        }
        
        try {
            if (this.device && this.device.GetTemplate) {
                // Using ActiveX control
                const quality = this.device.GetQuality();
                const template = this.device.GetTemplate();
                
                this.lastTemplate = template;
                this.lastQuality = quality;
                
                return {
                    template: template,
                    quality: quality,
                    success: quality > 40
                };
            } else {
                throw new Error("Device not properly initialized");
            }
        } catch (error) {
            console.error("Fingerprint capture failed:", error);
            throw error;
        }
    }

    async verify(storedTemplate) {
        if (!this.isInitialized) {
            throw new Error("Scanner not initialized");
        }
        
        try {
            if (this.device && this.device.MatchTemplate && this.lastTemplate) {
                const matched = this.device.MatchTemplate(storedTemplate, this.lastTemplate);
                
                return {
                    matched: matched,
                    score: matched ? 95 : 0
                };
            } else {
                throw new Error("Device not properly initialized or no template captured");
            }
        } catch (error) {
            console.error("Fingerprint verification failed:", error);
            throw error;
        }
    }

    getLastTemplate() {
        return this.lastTemplate;
    }

    getLastQuality() {
        return this.lastQuality;
    }

    reset() {
        this.lastTemplate = null;
        this.lastQuality = null;
    }
}

// Create global instance
window.MantraFingerprint = MantraFingerprint;

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Mantra fingerprint module loaded");
    });
} else {
    console.log("Mantra fingerprint module loaded");
}
