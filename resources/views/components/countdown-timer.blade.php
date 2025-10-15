@props(['endDate'])

<div class="countdown-timer bg-gradient-to-br from-blue-900 to-blue-800 rounded-xl p-6 shadow-2xl">
    <div class="text-center mb-6">
        <h3 class="text-2xl font-bold text-white mb-2">Pendaftaran Berakhir Dalam:</h3>
        <p class="text-blue-200 text-sm">Sisa waktu pendaftaran PPDB</p>
    </div>
    
    <div class="grid grid-cols-4 gap-4">
        <!-- Days -->
        <div class="countdown-item bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-white mb-1" id="countdown-days">00</div>
            <div class="text-sm text-blue-200 font-medium">Hari</div>
        </div>
        
        <!-- Hours -->
        <div class="countdown-item bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-white mb-1" id="countdown-hours">00</div>
            <div class="text-sm text-blue-200 font-medium">Jam</div>
        </div>
        
        <!-- Minutes -->
        <div class="countdown-item bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-white mb-1" id="countdown-minutes">00</div>
            <div class="text-sm text-blue-200 font-medium">Menit</div>
        </div>
        
        <!-- Seconds -->
        <div class="countdown-item bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
            <div class="text-3xl font-bold text-white mb-1" id="countdown-seconds">00</div>
            <div class="text-sm text-blue-200 font-medium">Detik</div>
        </div>
    </div>
    
    <!-- Status Message -->
    <div class="mt-4 text-center">
        <div id="countdown-status" class="text-white/80 text-sm">
            <span class="inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                Pendaftaran masih dibuka
            </span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const endDate = new Date('{{ $endDate }}').getTime();
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = endDate - now;
        
        if (distance < 0) {
            // Countdown finished
            document.getElementById('countdown-days').textContent = '00';
            document.getElementById('countdown-hours').textContent = '00';
            document.getElementById('countdown-minutes').textContent = '00';
            document.getElementById('countdown-seconds').textContent = '00';
            
            document.getElementById('countdown-status').innerHTML = `
                <span class="inline-flex items-center text-red-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Pendaftaran telah ditutup
                </span>
            `;
            return;
        }
        
        // Calculate time units
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Update display
        document.getElementById('countdown-days').textContent = days.toString().padStart(2, '0');
        document.getElementById('countdown-hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('countdown-minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('countdown-seconds').textContent = seconds.toString().padStart(2, '0');
        
        // Update status based on remaining time
        if (days <= 1) {
            document.getElementById('countdown-status').innerHTML = `
                <span class="inline-flex items-center text-yellow-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Waktu pendaftaran hampir habis!
                </span>
            `;
        } else if (days <= 7) {
            document.getElementById('countdown-status').innerHTML = `
                <span class="inline-flex items-center text-orange-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Sisa waktu pendaftaran: ${days} hari
                </span>
            `;
        } else {
            document.getElementById('countdown-status').innerHTML = `
                <span class="inline-flex items-center text-white/80">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Pendaftaran masih dibuka
                </span>
            `;
        }
    }
    
    // Update countdown every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
