Here is the final landing page with quizzes for each lesson and a WhatsApp chat navigation added to the bottom bar.
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>AlHilal Online Academy | Islamic Curriculum P.1–S.6</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fefaf3;
            color: #1e1a2f;
            scroll-behavior: smooth;
            padding-bottom: 80px;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f0e6ff; }
        ::-webkit-scrollbar-thumb { background: #9b6b9e; border-radius: 10px; }

        h1, h2, h3, h4 { font-weight: 700; line-height: 1.2; }
        
        .section-title {
            font-size: 1.9rem;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
            color: #4a1d6d;
        }
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 60px;
            height: 4px;
            background: #e35f5f;
            border-radius: 4px;
        }
        .text-center .section-title:after { left: 50%; transform: translateX(-50%); }
        
        .subheading {
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c24b4b;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.25s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-primary { background: #7c3a8c; color: white; box-shadow: 0 8px 18px rgba(124,58,140,0.25); }
        .btn-primary:hover { background: #5a2a6e; transform: translateY(-2px); }
        .btn-outline { background: transparent; border: 1.5px solid #7c3a8c; color: #7c3a8c; }
        .btn-outline:hover { background: #7c3a8c; color: white; }
        .btn-white { background: white; color: #7c3a8c; box-shadow: 0 5px 12px rgba(0,0,0,0.05); }
        .btn-view { background: #e35f5f; color: white; box-shadow: 0 4px 12px rgba(227,95,95,0.3); }
        .btn-view:hover { background: #c24b4b; transform: translateY(-2px); }
        .btn-quiz { background: #7c3a8c; color: white; font-size: 0.7rem; padding: 4px 12px; border-radius: 30px; margin-left: 8px; }
        .btn-quiz:hover { background: #5a2a6e; }
        
        .hero {
            min-height: 85vh;
            background: linear-gradient(135deg, #2d1b3a 0%, #4a2568 100%), url('https://images.unsplash.com/photo-1584556812952-905ffd0bebf6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-blend-mode: overlay;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding: 2rem 1.5rem;
            color: white;
        }
        .hero-content { max-width: 600px; margin: 0 auto; text-align: center; }
        .hero h1 { font-size: 2.5rem; margin: 1rem 0; }
        .hero-badge { background: rgba(255,255,240,0.2); backdrop-filter: blur(4px); padding: 6px 18px; border-radius: 40px; font-size: 0.8rem; display: inline-block; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        section { padding: 4rem 0; }
        .bg-soft { background-color: #faf7ff; }
        
        /* Level Cards */
        .levels-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .level-card {
            background: white;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            border: 1px solid #e9dfe5;
        }
        .level-header {
            background: #7c3a8c;
            color: white;
            padding: 1rem 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .level-header h3 { font-size: 1.2rem; margin: 0; display: flex; align-items: center; gap: 10px; }
        .level-header i { transition: transform 0.3s; }
        .level-header.collapsed i { transform: rotate(-90deg); }
        .level-body {
            padding: 1.2rem;
            background: #fffdf8;
            border-top: 1px solid #f0e3e5;
        }
        
        /* Class Tabs */
        .class-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #f0e3e5;
            padding-bottom: 1rem;
        }
        .class-tab {
            background: #f5eff9;
            border-radius: 30px;
            padding: 8px 18px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            color: #4a1d6d;
        }
        .class-tab.active {
            background: #e35f5f;
            color: white;
        }
        
        /* Subjects Grid */
        .subjects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }
        .subject-card {
            background: #fef9ef;
            border-radius: 20px;
            padding: 1rem;
            border: 1px solid #f0e3e5;
            transition: all 0.2s;
        }
        .subject-card h4 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #7c3a8c;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .lesson-list {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .lesson-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 10px;
            background: white;
            border-radius: 14px;
            font-size: 0.8rem;
            border: 1px solid #f0e3e5;
            flex-wrap: wrap;
            gap: 8px;
        }
        .lesson-info {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            flex: 1;
        }
        .lesson-type {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 20px;
            background: #f0e6ff;
        }
        .lesson-actions {
            display: flex;
            gap: 6px;
            align-items: center;
        }
        .view-btn {
            background: #e35f5f;
            color: white;
            border: none;
            padding: 4px 16px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .view-btn:hover { background: #c24b4b; }
        .quiz-btn {
            background: #7c3a8c;
            color: white;
            border: none;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .quiz-btn:hover { background: #5a2a6e; }
        .quiz-passed {
            background: #4caf50;
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        /* Stats */
        .stats-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1rem;
            background: linear-gradient(135deg, #7c3a8c, #9b4d96);
            border-radius: 60px;
            padding: 2rem 1.5rem;
            color: white;
            margin: 2rem 0;
        }
        .stat { text-align: center; flex: 1; }
        .stat-number { font-size: 2rem; font-weight: 800; }
        
        /* Feature Cards */
        .features-section {
            background: linear-gradient(135deg, #faf7ff 0%, #fff5f5 100%);
            border-radius: 48px;
            margin: 2rem 0;
            padding: 2rem 1.5rem;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .feature-card-large {
            background: white;
            border-radius: 28px;
            padding: 1.8rem;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            border: 1px solid #f0e3e5;
        }
        .feature-card-large:hover { transform: translateY(-5px); }
        .feature-card-large i { font-size: 2.8rem; color: #e35f5f; margin-bottom: 1rem; }
        .feature-card-large h3 { font-size: 1.4rem; margin-bottom: 0.8rem; color: #7c3a8c; }
        
        /* Testimonial */
        .testimonial-slide { background: white; border-radius: 32px; padding: 2rem; box-shadow: 0 12px 24px rgba(0,0,0,0.05); margin: 0.5rem; border: 1px solid #f0e3e5; }
        .stars { color: #e35f5f; margin-bottom: 1rem; }
        .user-info { display: flex; align-items: center; gap: 1rem; margin-top: 1.5rem; }
        .avatar { width: 52px; height: 52px; border-radius: 50%; background-size: cover; background-position: center; }
        
        /* Contact */
        .contact-card { background: white; border-radius: 36px; padding: 2rem; box-shadow: 0 25px 40px rgba(0,0,0,0.08); max-width: 700px; margin: 2rem auto 0; border: 1px solid #f0e3e5; }
        input, textarea { width: 100%; padding: 14px 18px; border-radius: 28px; border: 1px solid #e2dcd0; font-family: inherit; background: #fffdf9; margin-bottom: 1rem; }
        input:focus, textarea:focus { outline: none; border-color: #7c3a8c; box-shadow: 0 0 0 3px rgba(124,58,140,0.1); }
        
        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 253, 245, 0.98);
            backdrop-filter: blur(12px);
            display: flex;
            justify-content: space-around;
            padding: 0.7rem 0.8rem 1rem;
            border-top: 1px solid #f0e3e5;
            z-index: 1000;
        }
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            color: #8a7b9a;
            font-size: 0.7rem;
            font-weight: 500;
            flex: 1;
            transition: 0.2s;
            cursor: pointer;
        }
        .nav-item i { font-size: 1.5rem; }
        .nav-item.active { color: #7c3a8c; font-weight: 600; }
        .whatsapp-nav { color: #25D366; }
        .whatsapp-nav:hover { color: #128C7E; }
        
        footer { text-align: center; padding: 2rem 1rem 1rem; color: #6a5a7a; font-size: 0.8rem; border-top: 1px solid #f0e3e5; }
        
        @media (max-width: 640px) {
            .hero h1 { font-size: 2rem; }
            .section-title { font-size: 1.7rem; }
            .stats-row { flex-direction: column; align-items: center; border-radius: 32px; }
            .subjects-grid { grid-template-columns: 1fr; }
            .lesson-item { flex-direction: column; align-items: stretch; }
            .lesson-actions { justify-content: flex-end; }
        }
        
        /* Modals */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(5px); }
        .modal-content {
            background: white;
            border-radius: 32px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            text-align: center;
            border-top: 5px solid #e35f5f;
            animation: modalSlideIn 0.3s ease;
            max-height: 80vh;
            overflow-y: auto;
        }
        @keyframes modalSlideIn {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .quiz-question {
            background: #f9f5ff;
            padding: 1rem;
            border-radius: 20px;
            margin-bottom: 1rem;
            text-align: left;
        }
        .quiz-question p { font-weight: 600; margin-bottom: 0.5rem; color: #4a1d6d; }
        .quiz-option { display: flex; align-items: center; gap: 10px; padding: 8px; margin: 5px 0; cursor: pointer; border-radius: 12px; transition: 0.2s; }
        .quiz-option:hover { background: #f0e6ff; }
        .quiz-option input { width: auto; margin: 0; }
        .quiz-result { margin-top: 1rem; padding: 1rem; border-radius: 20px; font-weight: 600; }
        .quiz-result.passed { background: #e8f5e9; color: #2e7d32; }
        .quiz-result.failed { background: #ffebee; color: #c62828; }
        .close-modal-btn { margin-top: 1.5rem; background: #7c3a8c; color: white; border: none; padding: 10px 24px; border-radius: 40px; cursor: pointer; font-weight: 600; }
        .submit-quiz-btn { background: #e35f5f; color: white; border: none; padding: 12px 24px; border-radius: 40px; cursor: pointer; font-weight: 600; margin-top: 1rem; width: 100%; }
        .submit-quiz-btn:hover { background: #c24b4b; }
    </style>
</head>
<body>

<!-- HERO SECTION -->
<section class="hero" id="home">
    <div class="hero-content">
        <span class="hero-badge"><i class="fas fa-quran"></i> AlHilal Online Academy</span>
        <h1>Islamic Education<br>P.1 – S.6</h1>
        <p>Access premium Islamic lessons: Video, Audio, or PDF. Complete quizzes after each lesson to test your knowledge and earn certificates.</p>
        <div class="btn-group">
            <a href="#curriculum" class="btn btn-primary"><i class="fas fa-layer-group"></i> Browse Subjects</a>
            <a href="#features" class="btn btn-white"><i class="fas fa-chart-line"></i> Exams & Reports</a>
        </div>
    </div>
</section>

<!-- ABOUT Section -->
<section id="about">
    <div class="container">
        <div class="row" style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: center;">
            <div style="flex: 1;">
                <span class="subheading">Our Model</span>
                <h2 class="section-title">Learn, Test, Succeed</h2>
                <p style="margin: 1.5rem 0;">Each lesson contains video, audio, or PDF material. After completing a lesson, you must attempt a <strong>quiz</strong> to test your understanding. Pass the quiz to track your progress and earn certificates.</p>
                <p><strong>📚 S.1–S.6:</strong> 10+ advanced subjects including Tafsir, Hadith Sciences, Arabic Literature, Fiqh, Seerah, Islamic Economics, and more.</p>
                <a href="#curriculum" class="btn btn-outline" style="margin-top: 1rem;"><i class="fas fa-book-open"></i> Explore Levels</a>
            </div>
            <div style="flex: 1;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div style="background: white; border-radius: 24px; padding: 1rem; border: 1px solid #f0e3e5;"><i class="fas fa-video" style="font-size: 2rem; color:#e35f5f;"></i><h3 style="color:#7c3a8c;">Video Lessons</h3><p>Watch & Learn</p></div>
                    <div style="background: white; border-radius: 24px; padding: 1rem; border: 1px solid #f0e3e5;"><i class="fas fa-headphones" style="font-size: 2rem; color:#e35f5f;"></i><h3 style="color:#7c3a8c;">Audio Tracks</h3><p>Listen Anywhere</p></div>
                    <div style="background: white; border-radius: 24px; padding: 1rem; border: 1px solid #f0e3e5;"><i class="fas fa-file-pdf" style="font-size: 2rem; color:#e35f5f;"></i><h3 style="color:#7c3a8c;">PDF Notes</h3><p>Arabic + Translation</p></div>
                    <div style="background: white; border-radius: 24px; padding: 1rem; border: 1px solid #f0e3e5;"><i class="fas fa-question-circle" style="font-size: 2rem; color:#e35f5f;"></i><h3 style="color:#7c3a8c;">Lesson Quizzes</h3><p>Test Understanding</p></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES Section -->
<section id="features" class="bg-soft">
    <div class="container">
        <div class="text-center">
            <span class="subheading">Assessment & Recognition</span>
            <h2 class="section-title">Track Your Progress</h2>
            <p>Complete quizzes after each lesson, get instant results, and earn certificates</p>
        </div>
        <div class="features-grid">
            <div class="feature-card-large">
                <i class="fas fa-pen-alt"></i>
                <h3>Exams</h3>
                <p>Auto-graded quizzes and termly assessments to test your understanding. Instant feedback and performance analytics.</p>
            </div>
            <div class="feature-card-large">
                <i class="fas fa-chart-line"></i>
                <h3>Reports</h3>
                <p>Detailed progress reports for students, parents, and teachers. Track lesson completion, quiz scores, and improvement areas.</p>
            </div>
            <div class="feature-card-large">
                <i class="fas fa-certificate"></i>
                <h3>Certifications</h3>
                <p>Earn recognized certificates upon completing each level with all quizzes passed. Share your achievements online.</p>
            </div>
        </div>
    </div>
</section>

<!-- CURRICULUM Section -->
<section id="curriculum">
    <div class="container">
        <div class="text-center">
            <span class="subheading">Structured Islamic Curriculum</span>
            <h2 class="section-title">Classes, Subjects & Lessons</h2>
            <p>Each lesson includes content + a quiz. Pass the quiz to complete the lesson.</p>
        </div>
        <div class="levels-grid" id="levelsContainer"></div>
    </div>
</section>

<!-- Stats -->
<div class="container">
    <div class="stats-row">
        <div class="stat"><div class="stat-number">5</div><div>Levels</div></div>
        <div class="stat"><div class="stat-number">20+</div><div>Classes</div></div>
        <div class="stat"><div class="stat-number">60+</div><div>Subjects</div></div>
        <div class="stat"><div class="stat-number">500+</div><div>Lessons</div></div>
    </div>
</div>

<!-- TESTIMONIALS -->
<section id="testimony">
    <div class="container">
        <div class="text-center">
            <span class="subheading">Student Stories</span>
            <h2 class="section-title">What Our Community Says</h2>
        </div>
        <div class="swiper testimonialSwiper" style="margin-top: 2rem; overflow: hidden; padding: 1rem 0;">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><div class="testimonial-slide"><div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div><p>"The quizzes after each lesson really help reinforce what I learned. I love tracking my progress!"</p><div class="user-info"><div class="avatar" style="background-image: url('https://randomuser.me/api/portraits/women/68.jpg');"></div><div><strong>Amina Hussein</strong><br><span>S.3 Student</span></div></div></div></div>
                <div class="swiper-slide"><div class="testimonial-slide"><div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div><p>"The quiz system ensures students actually understand before moving on. Great platform for Islamic education."</p><div class="user-info"><div class="avatar" style="background-image: url('https://randomuser.me/api/portraits/men/45.jpg');"></div><div><strong>Ustadh Rashid</strong><br><span>Level 4 Teacher</span></div></div></div></div>
                <div class="swiper-slide"><div class="testimonial-slide"><div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div><p>"The WhatsApp chat feature is amazing! I can directly ask my teacher questions when I'm stuck."</p><div class="user-info"><div class="avatar" style="background-image: url('https://randomuser.me/api/portraits/men/32.jpg');"></div><div><strong>Ibrahim Ssemanda</strong><br><span>S.4 Candidate</span></div></div></div></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<footer>
    <p>© 2025 AlHilal Online Academy — Learn with quizzes | Video, Audio, PDF | Certifications & Reports</p>
    <p style="font-size:0.7rem;">info@alhilalacademy.org | +256 702 082 209</p>
</footer>

<!-- BOTTOM NAVIGATION with WhatsApp -->
<div class="bottom-nav">
    <a href="#home" class="nav-item" data-nav="home"><i class="fas fa-home"></i><span>Home</span></a>
    <a href="#payments" class="nav-item" data-nav="payments"><i class="fas fa-credit-card"></i><span>Payments</span></a>
    <a href="#testimony" class="nav-item" data-nav="testimony"><i class="fas fa-chart-line"></i><span>Reports</span></a>
    <a href="#notifications" class="nav-item" data-nav="notifications"><i class="fas fa-bell"></i><span>Notifications</span></a>
    <a href="#contact" class="nav-item" data-nav="contact"><i class="fas fa-certificate"></i><span>Certifications</span></a>
    <a href="#" class="nav-item whatsapp-nav" id="whatsappChat"><i class="fab fa-whatsapp"></i><span>Chat</span></a>
</div>

<!-- Lesson View Modal -->
<div id="lessonModal" class="modal-overlay">
    <div class="modal-content">
        <i class="fas fa-play-circle" style="font-size: 3rem; color: #7c3a8c;"></i>
        <h3 id="modalLessonTitle" style="margin: 1rem 0;">Lesson Title</h3>
        <div id="modalLessonIcon" style="font-size: 3rem; color: #e35f5f; margin: 1rem 0;"></div>
        <p id="modalLessonDescription">Click play to start learning this lesson.</p>
        <button class="close-modal-btn" onclick="closeLessonModal()">Close</button>
    </div>
</div>

<!-- Quiz Modal -->
<div id="quizModal" class="modal-overlay">
    <div class="modal-content">
        <i class="fas fa-question-circle" style="font-size: 3rem; color: #e35f5f;"></i>
        <h3 id="quizTitle" style="margin: 1rem 0;">Lesson Quiz</h3>
        <div id="quizQuestions"></div>
        <button class="submit-quiz-btn" id="submitQuizBtn">Submit Quiz</button>
        <div id="quizResult" class="quiz-result" style="display: none;"></div>
        <button class="close-modal-btn" id="closeQuizBtn" style="margin-top: 1rem;">Close</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Store quiz completion status
    let quizPassedLessons = JSON.parse(localStorage.getItem('quizPassedLessons') || '{}');
    
    function markQuizPassed(lessonId) {
        quizPassedLessons[lessonId] = true;
        localStorage.setItem('quizPassedLessons', JSON.stringify(quizPassedLessons));
    }
    
    function isQuizPassed(lessonId) {
        return quizPassedLessons[lessonId] === true;
    }
    
    // Generate quiz questions for a lesson
    function generateQuiz(lessonTitle) {
        return [
            { question: `What is the main topic of "${lessonTitle}"?`, options: ["Islamic Knowledge", "World History", "Mathematics", "Science"], correct: 0 },
            { question: `Which of the following is most important in understanding this lesson?`, options: ["Memorization", "Understanding Context", "Speed Reading", "Writing Notes"], correct: 1 },
            { question: `How does this lesson relate to Islamic teachings?`, options: ["Directly relates to Quran/Sunnah", "Only cultural", "Not related", "Historical only"], correct: 0 },
            { question: `What is the best way to apply knowledge from this lesson?`, options: ["Share with others", "Practice regularly", "Reflect and implement", "All of the above"], correct: 3 },
            { question: `Which scholar's work is most relevant to this topic?`, options: ["Imam Bukhari", "Imam Abu Hanifa", "Imam Ghazali", "Depends on context"], correct: 3 }
        ];
    }
    
    let currentQuizLesson = null;
    
    function showQuiz(lesson) {
        currentQuizLesson = lesson;
        const quizModal = document.getElementById('quizModal');
        const quizTitle = document.getElementById('quizTitle');
        const quizQuestionsDiv = document.getElementById('quizQuestions');
        const quizResultDiv = document.getElementById('quizResult');
        
        quizTitle.innerText = `Quiz: ${lesson.title}`;
        const quizData = generateQuiz(lesson.title);
        
        let quizHtml = '';
        quizData.forEach((q, idx) => {
            quizHtml += `
                <div class="quiz-question">
                    <p>${idx + 1}. ${q.question}</p>
                    ${q.options.map((opt, optIdx) => `
                        <label class="quiz-option">
                            <input type="radio" name="q${idx}" value="${optIdx}">
                            <span>${opt}</span>
                        </label>
                    `).join('')}
                </div>
            `;
        });
        
        quizQuestionsDiv.innerHTML = quizHtml;
        quizResultDiv.style.display = 'none';
        quizResultDiv.innerHTML = '';
        quizModal.style.display = 'flex';
        
        // Store quiz data for submission
        window.currentQuizData = quizData;
    }
    
    document.getElementById('submitQuizBtn').onclick = () => {
        const quizData = window.currentQuizData;
        if (!quizData) return;
        
        let score = 0;
        for (let i = 0; i < quizData.length; i++) {
            const selected = document.querySelector(`input[name="q${i}"]:checked`);
            if (selected && parseInt(selected.value) === quizData[i].correct) {
                score++;
            }
        }
        
        const passed = score >= 3; // Need at least 3 out of 5 to pass
        const quizResultDiv = document.getElementById('quizResult');
        
        if (passed) {
            markQuizPassed(currentQuizLesson.id);
            quizResultDiv.innerHTML = `<i class="fas fa-check-circle"></i> Congratulations! You passed the quiz (${score}/5). Lesson completed!`;
            quizResultDiv.className = 'quiz-result passed';
            // Refresh the lesson display to show quiz passed
            renderCurriculum();
        } else {
            quizResultDiv.innerHTML = `<i class="fas fa-times-circle"></i> You scored ${score}/5. You need at least 3 correct to pass. Please review the lesson and try again.`;
            quizResultDiv.className = 'quiz-result failed';
        }
        
        quizResultDiv.style.display = 'block';
    };
    
    document.getElementById('closeQuizBtn').onclick = () => {
        document.getElementById('quizModal').style.display = 'none';
        currentQuizLesson = null;
    };
    
    function showLessonModal(lesson) {
        const modal = document.getElementById('lessonModal');
        const titleEl = document.getElementById('modalLessonTitle');
        const iconContainer = document.getElementById('modalLessonIcon');
        const descEl = document.getElementById('modalLessonDescription');
        
        titleEl.innerText = lesson.title;
        descEl.innerText = lesson.description || `Learn about ${lesson.title} through this ${lesson.type} lesson.`;
        
        if (lesson.type === 'video') {
            iconContainer.innerHTML = '<i class="fas fa-video" style="font-size: 4rem;"></i><p style="margin-top: 0.5rem;">Watch Video Lesson</p>';
        } else if (lesson.type === 'audio') {
            iconContainer.innerHTML = '<i class="fas fa-headphones" style="font-size: 4rem;"></i><p style="margin-top: 0.5rem;">Listen to Audio</p>';
        } else {
            iconContainer.innerHTML = '<i class="fas fa-file-pdf" style="font-size: 4rem;"></i><p style="margin-top: 0.5rem;">View PDF Document</p>';
        }
        
        modal.style.display = 'flex';
    }
    
    function closeLessonModal() {
        document.getElementById('lessonModal').style.display = 'none';
    }
    
    // Generate curriculum with quiz tracking
    const levelsData = [
        { name: "Level 1 (P.1 - P.4)", classes: ["P.1", "P.2", "P.3", "P.4"], subjectsPerClass: 4 },
        { name: "Level 2 (P.5 - P.7)", classes: ["P.5", "P.6", "P.7"], subjectsPerClass: 4 },
        { name: "Level 3 (S.1 - S.3)", classes: ["S.1", "S.2", "S.3"], subjectsPerClass: 10 },
        { name: "Level 4 (S.4 - S.5)", classes: ["S.4", "S.5"], subjectsPerClass: 10 },
        { name: "Level 5 (S.6)", classes: ["S.6"], subjectsPerClass: 10 }
    ];
    
    const subjectNames = {
        primary: ["Qur'an (Tajweed)", "Lugha (Arabic)", "Fiqh (Ibadat)", "Seerah & Hadith"],
        secondary: [
            "Qur'an & Tafsir", "Arabic Grammar", "Fiqh (Worship)", "Hadith Sciences", "Seerah (Prophetic Biography)",
            "Islamic Creed (Aqeedah)", "Islamic History", "Moral Ethics (Akhlaq)", "Arabic Literature", "Islamic Jurisprudence (Usul)"
        ]
    };
    
    function generateLessons(subjectName, classLevel) {
        const lessonCount = Math.floor(Math.random() * 3) + 3;
        const lessons = [];
        const types = ['video', 'audio', 'pdf'];
        for (let i = 1; i <= lessonCount; i++) {
            const type = types[Math.floor(Math.random() * types.length)];
            lessons.push({
                id: `${classLevel}-${subjectName.replace(/\s/g, '')}-${i}`,
                title: `Lesson ${i}: ${subjectName} - ${type === 'video' ? 'Video Explanation' : type === 'audio' ? 'Audio Recitation' : 'PDF Notes'}`,
                type: type,
                description: `Learn about ${subjectName} in depth. This ${type} lesson covers key concepts for ${classLevel} students.`
            });
        }
        return lessons;
    }
    
    function renderCurriculum() {
        const container = document.getElementById('levelsContainer');
        container.innerHTML = '';
        
        levelsData.forEach((level, levelIdx) => {
            const levelDiv = document.createElement('div');
            levelDiv.className = 'level-card';
            let activeClass = level.classes[0];
            
            levelDiv.innerHTML = `
                <div class="level-header" data-level="${levelIdx}">
                    <h3><i class="fas fa-school"></i> ${level.name}</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="level-body" style="display: block">
                    <div class="class-tabs" id="class-tabs-${levelIdx}">
                        ${level.classes.map(cls => `<span class="class-tab" data-class="${cls}">${cls}</span>`).join('')}
                    </div>
                    <div id="subjects-container-${levelIdx}" data-current-class="${activeClass}"></div>
                </div>
            `;
            container.appendChild(levelDiv);
            
            const subjectsContainer = levelDiv.querySelector(`#subjects-container-${levelIdx}`);
            
            function renderSubjectsForClass(className) {
                const isSecondary = levelIdx >= 2;
                const subjectList = isSecondary ? subjectNames.secondary : subjectNames.primary;
                const numSubjects = level.subjectsPerClass;
                const selectedSubjects = subjectList.slice(0, numSubjects);
                
                let subjectsHtml = `<div class="subjects-grid">`;
                selectedSubjects.forEach(subj => {
                    const lessons = generateLessons(subj, className);
                    let lessonsHtml = `<div class="lesson-list">`;
                    lessons.forEach(lesson => {
                        const typeIcon = lesson.type === 'video' ? '<i class="fas fa-video"></i>' : lesson.type === 'audio' ? '<i class="fas fa-headphones"></i>' : '<i class="fas fa-file-pdf"></i>';
                        const quizPassed = isQuizPassed(lesson.id);
                        lessonsHtml += `
                            <div class="lesson-item">
                                <div class="lesson-info">
                                    <span class="lesson-type">${typeIcon} ${lesson.type.toUpperCase()}</span>
                                    <span>${lesson.title}</span>
                                </div>
                                <div class="lesson-actions">
                                    <button class="view-btn" data-lesson='${JSON.stringify(lesson)}'>View</button>
                                    ${quizPassed ? 
                                        '<span class="quiz-passed"><i class="fas fa-check-circle"></i> Quiz Passed</span>' : 
                                        `<button class="quiz-btn" data-lesson='${JSON.stringify(lesson)}'>Take Quiz</button>`
                                    }
                                </div>
                            </div>
                        `;
                    });
                    lessonsHtml += `</div>`;
                    subjectsHtml += `
                        <div class="subject-card">
                            <h4><i class="fas fa-star-of-life"></i> ${subj}</h4>
                            ${lessonsHtml}
                        </div>
                    `;
                });
                subjectsHtml += `</div>`;
                subjectsContainer.innerHTML = subjectsHtml;
                subjectsContainer.setAttribute('data-current-class', className);
                
                subjectsContainer.querySelectorAll('.view-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const lessonData = JSON.parse(btn.getAttribute('data-lesson'));
                        showLessonModal(lessonData);
                    });
                });
                
                subjectsContainer.querySelectorAll('.quiz-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const lessonData = JSON.parse(btn.getAttribute('data-lesson'));
                        showQuiz(lessonData);
                    });
                });
            }
            
            renderSubjectsForClass(activeClass);
            
            const tabsContainer = levelDiv.querySelector(`#class-tabs-${levelIdx}`);
            tabsContainer.querySelectorAll('.class-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    tabsContainer.querySelectorAll('.class-tab').forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    const selectedClass = tab.getAttribute('data-class');
                    renderSubjectsForClass(selectedClass);
                });
            });
            tabsContainer.querySelector('.class-tab')?.classList.add('active');
            
            const header = levelDiv.querySelector('.level-header');
            const body = levelDiv.querySelector('.level-body');
            header.addEventListener('click', (e) => {
                if(e.target.closest('.class-tab')) return;
                const isVisible = body.style.display !== 'none';
                body.style.display = isVisible ? 'none' : 'block';
                header.classList.toggle('collapsed', !isVisible);
            });
        });
    }
    
    renderCurriculum();
    
    // Close modals
    window.onclick = (e) => {
        const lessonModal = document.getElementById('lessonModal');
        const quizModal = document.getElementById('quizModal');
        if (e.target === lessonModal) closeLessonModal();
        if (e.target === quizModal) document.getElementById('quizModal').style.display = 'none';
    };
    
    // WhatsApp chat functionality
    document.getElementById('whatsappChat').onclick = (e) => {
        e.preventDefault();
        const phoneNumber = "256702082209"; // Teacher's WhatsApp number
        const message = encodeURIComponent("Assalamu Alaikum! I need assistance with my lessons on AlHilal Online Academy.");
        window.open(`https://wa.me/${phoneNumber}?text=${message}`, '_blank');
    };
    
    // Bottom nav active highlight
    const sections = document.querySelectorAll('section[id], .hero[id]');
    const navItems = document.querySelectorAll('.nav-item:not(.whatsapp-nav)');
    function updateActiveNav() {
        let scrollPos = window.scrollY + 120;
        sections.forEach(section => {
            const top = section.offsetTop, bottom = top + section.offsetHeight;
            if (scrollPos >= top && scrollPos < bottom) {
                const id = section.getAttribute('id');
                navItems.forEach(item => { 
                    item.classList.remove('active'); 
                    if (item.getAttribute('href') === `#${id}`) item.classList.add('active'); 
                });
            }
        });
    }
    window.addEventListener('scroll', updateActiveNav);
    window.addEventListener('load', updateActiveNav);
    
    document.querySelectorAll('.bottom-nav a:not(.whatsapp-nav), .btn-group a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId && targetId.startsWith('#') && targetId !== '#') {
                e.preventDefault();
                const target = document.querySelector(targetId);
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    
    new Swiper('.testimonialSwiper', { loop: true, slidesPerView: 1, spaceBetween: 20, pagination: { el: '.swiper-pagination', clickable: true }, breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } } });
    
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        let name = $('#fullname').val().trim();
        let email = $('#emailContact').val().trim();
        if (!name || !email) { Swal.fire('Error', 'Please fill name and email', 'warning'); return; }
        Swal.fire('Message Sent!', `Thank you ${name}, our team will contact you regarding enrollment.`, 'success');
        $('#contactForm')[0].reset();
    });
    
    const counters = document.querySelectorAll('.stat-number');
    const animateNumbers = () => { counters.forEach(c => { if (!c.dataset.animated) { let target = parseInt(c.innerText); let curr = 0; let inc = target/35; let up = () => { curr += inc; if(curr < target) { c.innerText = Math.floor(curr)+(target>20?'+':''); requestAnimationFrame(up); } else c.innerText = target+(target>20?'+':''); }; up(); c.dataset.animated = true; } }); };
    const observer = new IntersectionObserver((entries) => { entries.forEach(e => { if(e.isIntersecting) animateNumbers(); }); }, { threshold: 0.3 });
    const statsRow = document.querySelector('.stats-row');
    if(statsRow) observer.observe(statsRow);
</script>
</body>
</html>
```
```