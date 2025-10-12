/**
 * PPDB Multi-Step Form JavaScript
 * Handles form validation, step navigation, and auto-save functionality
 */

class PPDBForm {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 5;
        this.formData = {};
        this.init();
    }

    init() {
        this.loadSavedData();
        this.bindEvents();
        this.updateProgress();
        this.validateCurrentStep();
    }

    bindEvents() {
        // Step navigation
        document.querySelectorAll('[data-step]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const step = parseInt(button.dataset.step);
                this.goToStep(step);
            });
        });

        // Form input changes
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('change', () => {
                this.saveStepData();
                this.validateCurrentStep();
            });
        });

        // File upload
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', (e) => {
                this.handleFileUpload(e.target);
            });
        });

        // Form submission
        const submitForm = document.getElementById('submitForm');
        if (submitForm) {
            submitForm.addEventListener('click', (e) => {
                e.preventDefault();
                this.submitForm();
            });
        }

        // Prevent page leave with unsaved data
        window.addEventListener('beforeunload', (e) => {
            if (this.hasUnsavedData()) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    }

    goToStep(step) {
        if (step < 1 || step > this.totalSteps) return;

        // Validate current step before moving
        if (step > this.currentStep && !this.validateCurrentStep()) {
            this.showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
            return;
        }

        // Hide current step
        document.querySelector(`[data-step-content="${this.currentStep}"]`).classList.add('hidden');
        
        // Show target step
        document.querySelector(`[data-step-content="${step}"]`).classList.remove('hidden');
        
        this.currentStep = step;
        this.updateProgress();
        this.updateNavigation();
    }

    updateProgress() {
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        
        if (progressBar) {
            const percentage = (this.currentStep / this.totalSteps) * 100;
            progressBar.style.width = `${percentage}%`;
        }
        
        if (progressText) {
            progressText.textContent = `Langkah ${this.currentStep} dari ${this.totalSteps}`;
        }
    }

    updateNavigation() {
        // Update step indicators
        document.querySelectorAll('[data-step-indicator]').forEach(indicator => {
            const step = parseInt(indicator.dataset.stepIndicator);
            indicator.classList.remove('active', 'completed');
            
            if (step < this.currentStep) {
                indicator.classList.add('completed');
            } else if (step === this.currentStep) {
                indicator.classList.add('active');
            }
        });

        // Update navigation buttons
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        
        if (prevButton) {
            prevButton.style.display = this.currentStep > 1 ? 'block' : 'none';
        }
        
        if (nextButton) {
            if (this.currentStep < this.totalSteps) {
                nextButton.style.display = 'block';
                nextButton.textContent = 'Lanjut';
            } else {
                nextButton.style.display = 'block';
                nextButton.textContent = 'Submit Pendaftaran';
            }
        }
    }

    validateCurrentStep() {
        const currentStepElement = document.querySelector(`[data-step-content="${this.currentStep}"]`);
        const requiredFields = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
                this.showFieldError(field, 'Field ini wajib diisi');
            } else {
                this.clearFieldError(field);
            }
        });

        // Step-specific validation
        if (this.currentStep === 1) {
            isValid = this.validateStepOne() && isValid;
        } else if (this.currentStep === 2) {
            isValid = this.validateStepTwo() && isValid;
        } else if (this.currentStep === 3) {
            isValid = this.validateStepThree() && isValid;
        } else if (this.currentStep === 4) {
            isValid = this.validateStepFour() && isValid;
        }

        return isValid;
    }

    validateStepOne() {
        let isValid = true;

        // NIK validation
        const nik = document.getElementById('nik');
        if (nik && nik.value.length !== 16) {
            this.showFieldError(nik, 'NIK harus 16 digit');
            isValid = false;
        }

        // NISN validation
        const nisn = document.getElementById('nisn');
        if (nisn && nisn.value.length !== 10) {
            this.showFieldError(nisn, 'NISN harus 10 digit');
            isValid = false;
        }

        // Email validation
        const email = document.getElementById('email');
        if (email && !this.isValidEmail(email.value)) {
            this.showFieldError(email, 'Format email tidak valid');
            isValid = false;
        }

        // Phone validation
        const phone = document.getElementById('phone');
        if (phone && !this.isValidPhone(phone.value)) {
            this.showFieldError(phone, 'Format nomor telepon tidak valid');
            isValid = false;
        }

        return isValid;
    }

    validateStepTwo() {
        let isValid = true;

        // Father NIK validation
        const fatherNik = document.getElementById('father_nik');
        if (fatherNik && fatherNik.value.length !== 16) {
            this.showFieldError(fatherNik, 'NIK ayah harus 16 digit');
            isValid = false;
        }

        // Mother NIK validation
        const motherNik = document.getElementById('mother_nik');
        if (motherNik && motherNik.value.length !== 16) {
            this.showFieldError(motherNik, 'NIK ibu harus 16 digit');
            isValid = false;
        }

        return isValid;
    }

    validateStepThree() {
        let isValid = true;

        // School NPSN validation
        const schoolNpsn = document.getElementById('school_npsn');
        if (schoolNpsn && schoolNpsn.value.length !== 8) {
            this.showFieldError(schoolNpsn, 'NPSN sekolah harus 8 digit');
            isValid = false;
        }

        // Average score validation
        const averageScore = document.getElementById('average_score');
        if (averageScore) {
            const score = parseFloat(averageScore.value);
            if (isNaN(score) || score < 0 || score > 100) {
                this.showFieldError(averageScore, 'Nilai rata-rata harus antara 0-100');
                isValid = false;
            }
        }

        return isValid;
    }

    validateStepFour() {
        let isValid = true;
        const requiredDocuments = ['photo', 'ijazah', 'kk', 'akta'];

        requiredDocuments.forEach(docType => {
            const fileInput = document.querySelector(`input[name="documents[${docType}]"]`);
            if (fileInput && !fileInput.files.length) {
                this.showFieldError(fileInput, `Dokumen ${docType} wajib diupload`);
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        if (field.hasAttribute('required') && !field.value.trim()) {
            return false;
        }

        if (field.type === 'email' && field.value && !this.isValidEmail(field.value)) {
            return false;
        }

        if (field.type === 'tel' && field.value && !this.isValidPhone(field.value)) {
            return false;
        }

        return true;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidPhone(phone) {
        const phoneRegex = /^[0-9]{10,15}$/;
        return phoneRegex.test(phone.replace(/\D/g, ''));
    }

    showFieldError(field, message) {
        this.clearFieldError(field);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-red-500 text-sm mt-1 field-error';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
        field.classList.add('border-red-500');
    }

    clearFieldError(field) {
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
        field.classList.remove('border-red-500');
    }

    handleFileUpload(input) {
        const file = input.files[0];
        if (!file) return;

        // Validate file type
        const allowedTypes = this.getAllowedTypes(input.name);
        if (!allowedTypes.includes(file.type)) {
            this.showFieldError(input, 'Format file tidak diizinkan');
            input.value = '';
            return;
        }

        // Validate file size
        const maxSize = this.getMaxSize(input.name);
        if (file.size > maxSize) {
            this.showFieldError(input, `Ukuran file maksimal ${this.formatFileSize(maxSize)}`);
            input.value = '';
            return;
        }

        // Show preview for images
        if (file.type.startsWith('image/')) {
            this.showImagePreview(input, file);
        }

        this.clearFieldError(input);
        this.saveStepData();
    }

    getAllowedTypes(inputName) {
        const typeMap = {
            'documents[photo]': ['image/jpeg', 'image/png', 'image/jpg'],
            'documents[ijazah]': ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'],
            'documents[kk]': ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'],
            'documents[akta]': ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'],
            'documents[achievement]': ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'],
        };
        return typeMap[inputName] || ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
    }

    getMaxSize(inputName) {
        const sizeMap = {
            'documents[photo]': 1024 * 1024, // 1MB
            'documents[ijazah]': 2 * 1024 * 1024, // 2MB
            'documents[kk]': 2 * 1024 * 1024, // 2MB
            'documents[akta]': 2 * 1024 * 1024, // 2MB
            'documents[achievement]': 3 * 1024 * 1024, // 3MB
        };
        return sizeMap[inputName] || 2 * 1024 * 1024;
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    showImagePreview(input, file) {
        const previewContainer = input.parentNode.querySelector('.image-preview');
        if (!previewContainer) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            previewContainer.innerHTML = `
                <div class="relative">
                    <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-cover rounded-lg">
                    <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm" onclick="this.parentElement.parentElement.remove()">
                        ×
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }

    saveStepData() {
        const stepData = {};
        const currentStepElement = document.querySelector(`[data-step-content="${this.currentStep}"]`);
        
        currentStepElement.querySelectorAll('input, select, textarea').forEach(field => {
            if (field.type === 'file') {
                if (field.files.length > 0) {
                    stepData[field.name] = Array.from(field.files).map(file => ({
                        name: file.name,
                        size: file.size,
                        type: file.type
                    }));
                }
            } else {
                stepData[field.name] = field.value;
            }
        });

        this.formData[`step_${this.currentStep}`] = stepData;
        localStorage.setItem('ppdb_form_data', JSON.stringify(this.formData));
    }

    loadSavedData() {
        const savedData = localStorage.getItem('ppdb_form_data');
        if (savedData) {
            this.formData = JSON.parse(savedData);
            this.populateForm();
        }
    }

    populateForm() {
        Object.keys(this.formData).forEach(stepKey => {
            const stepData = this.formData[stepKey];
            Object.keys(stepData).forEach(fieldName => {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field && field.type !== 'file') {
                    field.value = stepData[fieldName];
                }
            });
        });
    }

    hasUnsavedData() {
        return Object.keys(this.formData).length > 0;
    }

    clearSavedData() {
        localStorage.removeItem('ppdb_form_data');
        this.formData = {};
    }

    async submitForm() {
        if (!this.validateCurrentStep()) {
            this.showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
            return;
        }

        // Show loading
        const submitButton = document.getElementById('submitForm');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengirim...';

        try {
            const formData = new FormData();
            
            // Collect all form data
            document.querySelectorAll('input, select, textarea').forEach(field => {
                if (field.type === 'file') {
                    if (field.files.length > 0) {
                        Array.from(field.files).forEach(file => {
                            formData.append(field.name, file);
                        });
                    }
                } else if (field.name) {
                    formData.append(field.name, field.value);
                }
            });

            const response = await fetch('/ppdb/daftar/submit', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();

            if (response.ok) {
                this.clearSavedData();
                window.location.href = result.redirect_url || '/ppdb/konfirmasi/' + result.registration_number;
            } else {
                throw new Error(result.message || 'Terjadi kesalahan saat mengirim formulir');
            }
        } catch (error) {
            this.showNotification(error.message, 'error');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'error' ? 'bg-red-500 text-white' : 
            type === 'success' ? 'bg-green-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

// Initialize form when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new PPDBForm();
});

