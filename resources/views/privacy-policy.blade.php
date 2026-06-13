<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Privacy Policy | Al Hilal Online Academy</title>
    <!-- Google Fonts + Tailwind CSS + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        .policy-card {
            backdrop-filter: blur(0px);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .policy-card:hover {
            box-shadow: 0 25px 35px -12px rgba(0, 0, 0, 0.12);
        }
        .section-divider {
            background: linear-gradient(90deg, #e2e8f0, #cbd5e1, #e2e8f0);
            height: 1px;
        }
        .icon-accent {
            background: linear-gradient(135deg, #0f2b3d, #1a4a6f);
        }
        .badge-glow {
            box-shadow: 0 8px 20px -8px rgba(26, 74, 111, 0.3);
        }
        @keyframes fadeSlideUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-up {
            animation: fadeSlideUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        .list-custom li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .list-custom li i {
            margin-top: 0.2rem;
            color: #1a4a6f;
            font-size: 1.1rem;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Main container with elegant spacing -->
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto animate-fade-up">
            
            <!-- Decorative header with academy identity -->
            <div class="text-center mb-8 md:mb-10">
                <div class="inline-flex items-center gap-3 bg-white/70 backdrop-blur-sm rounded-full px-5 py-2 shadow-sm border border-white/40 mb-5">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-600">Trusted & Transparent</span>
                </div>
                <div class="flex justify-center mb-3">
                    <div class="h-16 w-16 rounded-2xl icon-accent flex items-center justify-center shadow-lg badge-glow">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Privacy Policy</h1>
                <p class="text-slate-500 mt-3 max-w-2xl mx-auto text-sm md:text-base">Your data security is our sacred trust — read how we protect your learning journey at Al Hilal Online Academy.</p>
                <div class="flex justify-center mt-4">
                    <div class="inline-flex items-center gap-1 text-xs text-slate-400 bg-white/50 rounded-full px-3 py-1">
                        <i class="far fa-calendar-alt"></i>
                        <span>Last updated: <span id="lastUpdatedDate"></span></span>
                    </div>
                </div>
            </div>

            <!-- Main policy card - elegant & modern -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl policy-card overflow-hidden border border-white/30 transition-all duration-300">
                <!-- subtle pattern overlay -->
                <div class="absolute inset-0 pointer-events-none opacity-5" style="background-image: radial-gradient(#1a4a6f 1px, transparent 1px); background-size: 24px 24px;"></div>
                
                <div class="relative p-6 md:p-10 lg:p-12">
                    
                    <!-- greeting intro -->
                    <div class="mb-8 pb-2 border-b border-slate-100">
                        <p class="text-slate-700 leading-relaxed text-base">
                            At <strong class="font-semibold text-slate-800">Al Hilal Online Academy</strong>, we are committed to protecting your privacy and ensuring the security of your personal information.
                            This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our mobile application and services.
                        </p>
                        <p class="text-slate-700 leading-relaxed mt-4">
                            By using <strong class="font-semibold text-slate-800">Al Hilal Online Academy</strong>, you agree to the terms outlined in this policy.
                            If you do not agree with these terms, please do not use our app.
                        </p>
                    </div>

                    <!-- 1. Information We Collect -->
                    <div class="mb-10">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-700"><i class="fas fa-database text-sm"></i></div>
                            <h2 class="text-2xl font-bold text-slate-800">1. Information We Collect</h2>
                        </div>
                        <div class="space-y-5">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 flex items-center gap-2"><i class="fas fa-user-circle text-indigo-500 text-sm"></i> Personal Information</h3>
                                <p class="text-slate-600 mt-1">When you register or use our app, we may ask for:</p>
                                <ul class="list-custom mt-2 ml-1">
                                    <li><i class="fas fa-check-circle text-xs mt-1"></i><span>Your name, email address, and phone number.</span></li>
                                    <li><i class="fas fa-check-circle text-xs mt-1"></i><span>Payment information (if you enroll in paid courses).</span></li>
                                    <li><i class="fas fa-check-circle text-xs mt-1"></i><span>Profile information (e.g., profile picture, bio).</span></li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 flex items-center gap-2"><i class="fas fa-chart-line text-indigo-500 text-sm"></i> Usage Data</h3>
                                <p class="text-slate-600 mt-1">We automatically collect certain information when you use our app, such as:</p>
                                <ul class="list-custom mt-2 ml-1">
                                    <li><i class="fas fa-mobile-alt text-xs mt-1"></i><span>Device information (e.g., device type, OS version, unique device identifiers).</span></li>
                                    <li><i class="fas fa-globe text-xs mt-1"></i><span>IP address and browser type.</span></li>
                                    <li><i class="fas fa-clock text-xs mt-1"></i><span>Pages viewed, time spent on the app, and other usage statistics.</span></li>
                                    <li><i class="fas fa-cookie-bite text-xs mt-1"></i><span>Cookies and similar technologies to enhance your experience.</span></li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-800 flex items-center gap-2"><i class="fas fa-graduation-cap text-indigo-500 text-sm"></i> Course and Learning Data</h3>
                                <p class="text-slate-600 mt-1">To provide a personalized learning experience, we may collect:</p>
                                <ul class="list-custom mt-2 ml-1">
                                    <li><i class="fas fa-book-open text-xs mt-1"></i><span>Courses you enroll in, complete, or abandon.</span></li>
                                    <li><i class="fas fa-chart-simple text-xs mt-1"></i><span>Your progress in courses, including quiz scores and lesson completion.</span></li>
                                    <li><i class="fas fa-star text-xs mt-1"></i><span>Feedback and reviews you provide for courses.</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="section-divider my-6"></div>

                    <!-- 2. How We Use Your Information -->
                    <div class="mb-10 mt-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-700"><i class="fas fa-cogs text-sm"></i></div>
                            <h2 class="text-2xl font-bold text-slate-800">2. How We Use Your Information</h2>
                        </div>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2">
                            <li class="flex gap-2 items-start"><i class="fas fa-check text-emerald-600 mt-1 text-sm"></i><span class="text-slate-600">Provide, maintain, and improve our services.</span></li>
                            <li class="flex gap-2 items-start"><i class="fas fa-check text-emerald-600 mt-1 text-sm"></i><span class="text-slate-600">Personalize your learning experience & recommend courses.</span></li>
                            <li class="flex gap-2 items-start"><i class="fas fa-check text-emerald-600 mt-1 text-sm"></i><span class="text-slate-600">Process payments and send transactional emails.</span></li>
                            <li class="flex gap-2 items-start"><i class="fas fa-check text-emerald-600 mt-1 text-sm"></i><span class="text-slate-600">Communicate updates, promotions, and important notices.</span></li>
                            <li class="flex gap-2 items-start"><i class="fas fa-check text-emerald-600 mt-1 text-sm"></i><span class="text-slate-600">Monitor usage trends to enhance app performance.</span></li>
                            <li class="flex gap-2 items-start"><i class="fas fa-check text-emerald-600 mt-1 text-sm"></i><span class="text-slate-600">Detect, prevent technical issues or fraudulent activity.</span></li>
                            <li class="flex gap-2 items-start"><i class="fas fa-check text-emerald-600 mt-1 text-sm"></i><span class="text-slate-600">Comply with legal obligations & enforce terms of service.</span></li>
                        </ul>
                    </div>
                    <div class="section-divider my-6"></div>

                    <!-- 3. Sharing & 4. Data Security -->
                    <div class="grid md:grid-cols-2 gap-8 mb-10">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-7 h-7 rounded-full bg-amber-50 flex items-center justify-center text-amber-600"><i class="fas fa-share-alt text-xs"></i></div>
                                <h2 class="text-xl font-bold text-slate-800">3. How We Share Info</h2>
                            </div>
                            <p class="text-slate-600 text-sm mb-2">We do <span class="font-bold text-red-600">not sell</span> your personal information. Limited sharing:</p>
                            <ul class="space-y-2 text-slate-600 text-sm">
                                <li class="flex gap-2"><i class="fas fa-hand-peace text-amber-600 text-xs mt-1"></i><span><strong>With Consent:</strong> Explicit permission.</span></li>
                                <li class="flex gap-2"><i class="fas fa-handshake text-amber-600 text-xs mt-1"></i><span><strong>Service Providers:</strong> Payment processors, cloud storage.</span></li>
                                <li class="flex gap-2"><i class="fas fa-gavel text-amber-600 text-xs mt-1"></i><span><strong>Legal Reasons:</strong> Court orders, government requests.</span></li>
                                <li class="flex gap-2"><i class="fas fa-chart-line text-amber-600 text-xs mt-1"></i><span><strong>Aggregated Data:</strong> Non-personal stats for research.</span></li>
                            </ul>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-700"><i class="fas fa-lock text-xs"></i></div>
                                <h2 class="text-xl font-bold text-slate-800">4. Data Security</h2>
                            </div>
                            <ul class="space-y-2 text-slate-600 text-sm">
                                <li class="flex gap-2"><i class="fas fa-key text-blue-500 text-xs mt-1"></i><span>Encryption of sensitive data (payments).</span></li>
                                <li class="flex gap-2"><i class="fas fa-database text-blue-500 text-xs mt-1"></i><span>Secure storage & access controls.</span></li>
                                <li class="flex gap-2"><i class="fas fa-sync-alt text-blue-500 text-xs mt-1"></i><span>Regular security audits & updates.</span></li>
                            </ul>
                            <p class="text-slate-500 text-xs mt-3 italic">⚠️ No internet transmission is 100% secure, yet we strive for maximum protection.</p>
                        </div>
                    </div>
                    <div class="section-divider my-6"></div>

                    <!-- 5 + 6 + 7: Data Retention, Rights, Children -->
                    <div class="space-y-6 mb-8">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-hourglass-half text-slate-500 text-sm"></i> 5. Data Retention</h2>
                            <p class="text-slate-600">We retain personal information as long as necessary for the purposes outlined. You may request deletion by contacting us.</p>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-user-check text-slate-500 text-sm"></i> 6. Your Rights & Choices</h2>
                            <p class="text-slate-600">Depending on location, you may have rights to access, correction, deletion, portability, and opt-out of promotions.</p>
                            <div class="bg-slate-50 rounded-xl p-4 mt-3 border border-slate-100">
                                <p class="text-slate-700 text-sm">✉️ To exercise your rights, contact us at: <a href="mailto:privacy@alhilalacademy.com" class="text-indigo-600 font-medium hover:underline">privacy@alhilalacademy.com</a></p>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-child text-slate-500 text-sm"></i> 7. Children’s Privacy</h2>
                            <p class="text-slate-600">Our app is <strong>not intended for children under 13</strong>. We do not knowingly collect data from children under 13. If identified, we delete it immediately.</p>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-external-link-alt text-slate-500 text-sm"></i> 8. Third-Party Links</h2>
                            <p class="text-slate-600">Our app may contain links to third-party websites. We are not responsible for their privacy practices — please review their policies.</p>
                        </div>
                    </div>
                    <div class="section-divider my-5"></div>

                    <!-- 9. Changes + Last Updated and Contact -->
                    <div class="grid md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-history text-slate-500"></i> 9. Changes to Policy</h2>
                            <p class="text-slate-600">We may update this policy from time to time. Changes will be posted here with the "Last Updated" date.</p>
                            <div class="mt-3 p-3 bg-gradient-to-r from-slate-50 to-white rounded-lg border border-slate-200 inline-block">
                                <span class="text-xs font-mono text-slate-500"><i class="far fa-calendar-check"></i> <strong>Last Updated:</strong> <span id="footerUpdatedDate"></span></span>
                            </div>
                        </div>
                        <div class="bg-slate-800/5 rounded-2xl p-5 border border-slate-200">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-envelope-open-text text-slate-700 text-xl"></i>
                                <h3 class="font-bold text-slate-800 text-lg">📞 10. Contact Us</h3>
                            </div>
                            <p class="text-slate-700 text-sm">Have questions or concerns? Our privacy team responds within 48 hours.</p>
                            <p class="mt-3"><strong class="text-slate-800">Email:</strong> <a href="mailto:support@alhilalacademy.com" class="text-indigo-600 hover:underline break-all">support@alhilalacademy.com</a></p>
                            <p class="mt-1"><strong class="text-slate-800">Address:</strong> Al Hilal Online Academy, Knowledge Oasis, Doha, Qatar</p>
                        </div>
                    </div>

                    <!-- fine print decorative line -->
                    <div class="mt-10 pt-5 text-center text-xs text-slate-400 border-t border-slate-200 flex flex-wrap justify-between items-center">
                        <span>© 2025 Al Hilal Online Academy — Empowering minds, respecting privacy.</span>
                        <span class="flex gap-2"><i class="fab fa-cc-visa"></i> <i class="fab fa-cc-mastercard"></i> <i class="fab fa-cc-paypal"></i> PCI Compliant</span>
                    </div>
                </div>
            </div>

            <!-- quick floating trust badge -->
            <div class="flex justify-center mt-8 text-sm text-slate-500 gap-4">
                <div class="flex items-center gap-1 bg-white/60 backdrop-blur-sm rounded-full px-4 py-1.5 shadow-sm"><i class="fas fa-check-circle text-emerald-500"></i> <span>GDPR Ready</span></div>
                <div class="flex items-center gap-1 bg-white/60 backdrop-blur-sm rounded-full px-4 py-1.5 shadow-sm"><i class="fas fa-lock text-indigo-500"></i> <span>SSL Encrypted</span></div>
                <div class="flex items-center gap-1 bg-white/60 backdrop-blur-sm rounded-full px-4 py-1.5 shadow-sm"><i class="fas fa-database text-amber-500"></i> <span>Data minimized</span></div>
            </div>
        </div>
    </div>
    
    <script>
        // set dynamic last updated date based on current date
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const today = new Date();
        const formattedDate = today.toLocaleDateString('en-US', options);
        const dateSpans = document.querySelectorAll('#lastUpdatedDate, #footerUpdatedDate');
        dateSpans.forEach(span => {
            if(span) span.innerText = formattedDate;
        });
        // if any element fails due to dynamic creation, extra handling
        if(document.getElementById('lastUpdatedDate')) document.getElementById('lastUpdatedDate').innerText = formattedDate;
        if(document.getElementById('footerUpdatedDate')) document.getElementById('footerUpdatedDate').innerText = formattedDate;
    </script>
</body>
</html>