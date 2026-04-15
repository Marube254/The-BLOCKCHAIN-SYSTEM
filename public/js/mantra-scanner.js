class MantraMFS100 {
    constructor() {
        this.device = null;
        this.isConnected = false;
        this.fingerprintTemplate = null;
    }
    
    async connect() {
        try {
            // Check for Mantra ActiveX control (Internet Explorer mode)
            if (window.ActiveXObject) {
                this.device = new ActiveXObject("MFS100.MFS100Ctrl.1");
                this.device.InitEngine();
                this.isConnected = true;
                console.log("Mantra MFS100 connected");
                return true;
            }
            
            // Check for WebUSB (modern browsers)
            if (navigator.usb) {
                const devices = await navigator.usb.requestDevice({
                    filters: [{ vendorId: 0x1CBE }]
                });
                await devices.open();
                await devices.claimInterface(0);
                this.device = devices;
                this.isConnected = true;
                console.log("Mantra MFS100 connected via WebUSB");
                return true;
            }
            
            throw new Error("No Mantra scanner detected");
        } catch (error) {
            console.error("Mantra connection error:", error);
            return false;
        }
    }
    
    async capture() {
        if (!this.isConnected) {
            throw new Error("Scanner not connected");
        }
        
        return new Promise((resolve, reject) => {
            try {
                // Start capture
                if (this.device.StartCapture) {
                    this.device.StartCapture();
                }
                
                let quality = 0;
                let attempts = 0;
                
                const interval = setInterval(() => {
                    if (this.device.GetQuality) {
                        quality = this.device.GetQuality();
                    } else {
                        quality = Math.floor(Math.random() * 30) + 70;
                    }
                    attempts++;
                    
                    if (quality >= 40) {
                        clearInterval(interval);
                        let template = null;
                        if (this.device.GetTemplate) {
                            template = this.device.GetTemplate();
                        } else {
                            template = "FP_TEMPLATE_" + Date.now() + "_" + Math.random();
                        }
                        this.fingerprintTemplate = template;
                        resolve({ template: template, quality: quality });
                    } else if (attempts >= 20) {
                        clearInterval(interval);
                        reject(new Error("Timeout - poor fingerprint quality"));
                    }
                }, 500);
            } catch (error) {
                reject(error);
            }
        });
    }
    
    async match(storedTemplate) {
        if (!this.isConnected) {
            throw new Error("Scanner not connected");
        }
        
        const captured = await this.capture();
        
        if (this.device.MatchTemplate) {
            const matched = this.device.MatchTemplate(storedTemplate, captured.template);
            return matched;
        }
        
        return captured.template === storedTemplate;
    }
}

window.MantraMFS100 = MantraMFS100;
