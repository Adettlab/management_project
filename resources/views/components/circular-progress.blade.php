<!-- Circular Progress Component -->
<div class="relative w-36 h-36">
    <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
        <!-- Background Circle -->
        <circle cx="18" cy="18" r="16" fill="none" class="stroke-current black-primary" stroke-width="4">
        </circle>
        <!-- Progress Circle -->
        <circle id="progress-circle-{{ $progres }}" cx="18" cy="18" r="16" fill="none"
            class="stroke-current text-blue-600" stroke-width="4" stroke-dasharray="100" stroke-linecap="round">
        </circle>
    </svg>
    <!-- Percentage Text -->
    <div class="absolute inset-0 flex items-center justify-center">
        <span id="percentage-text-{{ $progres }}"
            class="text-2xl font-bold text-blue-600">{{ $progres }}%</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select the circle and percentage text based on the progres ID
        const circle = document.getElementById('progress-circle-{{ $progres }}');
        const text = document.getElementById('percentage-text-{{ $progres }}');

        // Calculate stroke-dashoffset based on progres
        const offset = 100 - {{ $progres }};
        circle.style.strokeDashoffset = offset;

        // Update text to show the percentage
        text.textContent = `{{ $progres }}%`;
    });
</script>
