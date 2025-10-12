<!-- Facility Detail Modal -->
<div id="facilityModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeFacilityModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-2xl font-bold text-gray-900" id="modalTitle">Detail Fasilitas</h3>
                <button onclick="closeFacilityModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Image -->
                    <div>
                        <img id="modalImage" src="" alt="" class="w-full h-64 object-cover rounded-lg shadow-lg">
                    </div>
                    
                    <!-- Details -->
                    <div class="space-y-6">
                        <!-- Status and Category -->
                        <div class="flex flex-wrap gap-2">
                            <span id="modalStatus" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"></span>
                            <span id="modalCategory" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800"></span>
                        </div>
                        
                        <!-- Capacity -->
                        <div id="modalCapacity" class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            <span id="modalCapacityText"></span>
                        </div>
                        
                        <!-- Description -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h4>
                            <p id="modalDescription" class="text-gray-600 leading-relaxed"></p>
                        </div>
                        
                        <!-- Features -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Fitur Fasilitas</h4>
                            <ul id="modalFeatures" class="space-y-2">
                                <!-- Features will be populated by JavaScript -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-between p-6 border-t bg-gray-50">
                <button onclick="closeFacilityModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-200">
                    Tutup
                </button>
                <a id="modalViewDetail" href="#" class="px-6 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
                    Lihat Detail Lengkap
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openFacilityModal(facilityId) {
    // Fetch facility data via AJAX
    fetch(`/api/facilities/${facilityId}`)
        .then(response => response.json())
        .then(data => {
            // Populate modal with data
            document.getElementById('modalTitle').textContent = data.name;
            document.getElementById('modalImage').src = data.image_url;
            document.getElementById('modalImage').alt = data.name;
            document.getElementById('modalDescription').textContent = data.description;
            document.getElementById('modalViewDetail').href = `/fasilitas/${data.id}`;
            
            // Status badge
            const statusElement = document.getElementById('modalStatus');
            if (data.is_available) {
                statusElement.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
                statusElement.innerHTML = '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Tersedia';
            } else {
                statusElement.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
                statusElement.innerHTML = '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>Tidak Tersedia';
            }
            
            // Category
            const categoryElement = document.getElementById('modalCategory');
            if (data.category) {
                categoryElement.textContent = data.category.name;
                categoryElement.style.display = 'inline-flex';
            } else {
                categoryElement.style.display = 'none';
            }
            
            // Capacity
            const capacityElement = document.getElementById('modalCapacity');
            const capacityText = document.getElementById('modalCapacityText');
            if (data.capacity) {
                capacityText.textContent = `Kapasitas: ${data.capacity} orang`;
                capacityElement.style.display = 'flex';
            } else {
                capacityElement.style.display = 'none';
            }
            
            // Features (static for now)
            const featuresElement = document.getElementById('modalFeatures');
            featuresElement.innerHTML = `
                <li class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Fasilitas lengkap dan modern
                </li>
                <li class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Didukung teknologi terbaru
                </li>
                <li class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Lingkungan yang nyaman dan kondusif
                </li>
            `;
            
            // Show modal
            document.getElementById('facilityModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error fetching facility data:', error);
            alert('Gagal memuat data fasilitas');
        });
}

function closeFacilityModal() {
    document.getElementById('facilityModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeFacilityModal();
    }
});
</script>

