@include('Teacher.layouts.sidebar-navbar')

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // ── ADD LESSON MODAL ──────────────────────────────────────
        const levelClassesMap = {
            "Level 1": ["P.1", "P.2", "P.3", "P.4"],
            "Level 2": ["P.5", "P.6", "P.7"],
            "Level 3": ["S.1", "S.2", "S.3"],
            "Level 4": ["S.4", "S.5"],
            "Level 5": ["S.6"]
        };
        let selectedFile = null;

        function openAddLessonModal() {
            document.getElementById('addLessonForm').reset();
            document.getElementById('lessonClass').innerHTML = '<option value="">Select Class</option>';
            clearFile();
            document.getElementById('addLessonModal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeAddLessonModal() {
            document.getElementById('addLessonModal').classList.remove('open');
            document.body.style.overflow = '';
            document.getElementById('addLessonForm').reset();
            document.getElementById('lessonClass').innerHTML = '<option value="">Select Class</option>';
            clearFile();
        }

        document.getElementById('addLessonBtn').addEventListener('click', function (e) {
            e.preventDefault();
            openAddLessonModal();
        });

        document.getElementById('lessonLevel').addEventListener('change', function () {
            const classSelect = document.getElementById('lessonClass');
            classSelect.innerHTML = '<option value="">Select Class</option>';
            if (this.value && levelClassesMap[this.value]) {
                levelClassesMap[this.value].forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = `${this.value} (${c})`;
                    opt.textContent = c;
                    classSelect.appendChild(opt);
                });
            }
        });

        document.getElementById('fileInput').addEventListener('change', function () {
            if (this.files && this.files[0]) {
                selectedFile = this.files[0];
                if (selectedFile.size > 50 * 1024 * 1024) {
                    alert('File size exceeds 50MB limit');
                    this.value = ''; selectedFile = null;
                    document.getElementById('fileInfo').style.display = 'none';
                    return;
                }
                document.getElementById('fileName').textContent =
                    `${selectedFile.name} (${(selectedFile.size / (1024 * 1024)).toFixed(2)} MB)`;
                document.getElementById('fileInfo').style.display = 'block';
            }
        });

        function clearFile() {
            selectedFile = null;
            document.getElementById('fileInput').value = '';
            document.getElementById('fileInfo').style.display = 'none';
        }

        // Close modal when clicking backdrop
        document.getElementById('addLessonModal').addEventListener('click', function (e) {
            if (e.target === this) closeAddLessonModal();
        });

        document.getElementById('addLessonForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('lesson_number', document.getElementById('lessonNumber').value);
            formData.append('lesson_title', document.getElementById('lessonTitle').value);
            formData.append('lesson_subject', document.getElementById('lessonSubject').value);
            formData.append('lesson_level', document.getElementById('lessonLevel').value);
            formData.append('lesson_class', document.getElementById('lessonClass').value);
            formData.append('lesson_type', document.getElementById('lessonType').value);
            formData.append('content_url', document.getElementById('contentUrl').value);
            formData.append('lesson_desc', document.getElementById('lessonDesc').value);
            formData.append('lesson_duration', document.getElementById('lessonDuration').value);
            formData.append('lesson_price', document.getElementById('lessonPrice').value);
            formData.append('lesson_status', document.getElementById('lessonStatus').value);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
            if (selectedFile) formData.append('lesson_file', selectedFile);

            fetch('/teacher/upload-lesson', {
                method: 'POST',
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        closeAddLessonModal();
                        alert('Lesson saved successfully!');
                    } else {
                        alert(data.message || 'Something went wrong');
                    }
                })
                .catch(() => alert('Failed to save lesson. Please try again.'));
        });
    </script>

    <script>
        // ── Engagement Line Chart ──────────────────────────────────
        const engCtx = document.getElementById('engagementChart').getContext('2d');

        const engGrad = engCtx.createLinearGradient(0, 0, 0, 240);
        engGrad.addColorStop(0, 'rgba(107,70,193,0.3)');
        engGrad.addColorStop(1, 'rgba(107,70,193,0)');

        new Chart(engCtx, {
            type: 'line',
            data: {
                labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{
                    label: 'Completions',
                    data: [42, 68, 54, 89, 73, 95, 61],
                    borderColor: '#6B46C1',
                    backgroundColor: engGrad,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.45,
                    pointBackgroundColor: '#6B46C1',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }, {
                    label: 'Logins',
                    data: [55, 80, 66, 102, 88, 110, 74],
                    borderColor: '#DC2626',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.45,
                    pointBackgroundColor: '#DC2626',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    borderDash: [5, 3],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            font: { family: 'DM Sans', size: 11 },
                            color: '#6B6584',
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1A0A2E',
                        titleFont: { family: 'Playfair Display', size: 13 },
                        bodyFont: { family: 'DM Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(107,70,193,0.08)' },
                        ticks: { font: { family: 'DM Sans', size: 11 }, color: '#6B6584' }
                    },
                    y: {
                        grid: { color: 'rgba(107,70,193,0.08)' },
                        ticks: { font: { family: 'DM Sans', size: 11 }, color: '#6B6584' }
                    }
                }
            }
        });

        // ── Attendance Doughnut Chart ─────────────────────────────
        const attCtx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(attCtx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late'],
                datasets: [{
                    data: [91, 6, 3],
                    backgroundColor: ['#16A34A', '#DC2626', '#D97706'],
                    borderColor: '#FDFBF7',
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            font: { family: 'DM Sans', size: 11 },
                            color: '#6B6584',
                            padding: 12,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1A0A2E',
                        titleFont: { family: 'Playfair Display', size: 13 },
                        bodyFont: { family: 'DM Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                    }
                }
            }
        });

        // ── Sidebar Mobile Toggle ─────────────────────────────────
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }
        document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);

        // ── Dropdown Toggle ───────────────────────────────────────
        function toggleDropdown(dropId, btnId) {
            const drop = document.getElementById(dropId);
            const isOpen = drop.classList.contains('open');
            // Close all
            document.querySelectorAll('.notif-dropdown, .profile-dropdown').forEach(d => d.classList.remove('open'));
            if (!isOpen) drop.classList.add('open');
        }
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#notifBtn') && !e.target.closest('#notifDropdown')) {
                document.getElementById('notifDropdown').classList.remove('open');
            }
            if (!e.target.closest('#profileBtn') && !e.target.closest('#profileDropdown')) {
                document.getElementById('profileDropdown').classList.remove('open');
            }
        });

        // ── Header scroll shadow ──────────────────────────────────
        window.addEventListener('scroll', () => {
            document.querySelector('.topbar').style.boxShadow =
                window.scrollY > 10 ? '0 4px 20px rgba(107,70,193,0.1)' : 'none';
        });

        // ── KPI card entrance animation ───────────────────────────
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.kpi-card, .card, .qa-btn').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(16px)';
            el.style.transition = `opacity 0.4s ease ${i * 0.05}s, transform 0.4s ease ${i * 0.05}s`;
            observer.observe(el);
        });
    </script>
@endsection