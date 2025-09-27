<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include common header
include("includes/header.php");
?>

<main class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 p-4">
                <h1 class="mb-4 text-center text-primary fw-bold">🌐 About Online Quiz </h1>
                
                <p class="lead text-justify">
                    Welcome to <strong>Online Quiz </strong> – your trusted companion in learning, practicing, 
                    and mastering knowledge through engaging quizzes. In today’s fast-paced digital world, education 
                    should not be limited to classrooms. Students need a smart, flexible, and interactive platform 
                    that helps them <em>learn anytime, anywhere</em>. That is exactly where Online Quiz comes in.
                </p>

                <h3 class="mt-4 text-success">📖 Our Story</h3>
                <p>
                    The idea of Online Quiz  started with a simple question: 
                    <em>“Why should learning feel boring when technology can make it exciting?”</em>  
                    Many students struggle to track their progress or get quick feedback. Teachers too find it 
                    difficult to create and evaluate quizzes. To solve this, we built a platform that makes quizzes 
                    <strong>easy to create, simple to attempt, and powerful in results</strong>.
                </p>

                <h3 class="mt-4 text-success">🎯 Our Vision</h3>
                <p>
                    We believe quizzes are not just tests, they are <strong>learning tools</strong>.  
                    Our vision is simple:  
                    <em>“To transform traditional learning into a smart, interactive, and limitless experience for everyone.”</em>
                </p>

                <h3 class="mt-4 text-success">🚀 Our Mission</h3>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item">📌 Students can practice regularly, test themselves, and track progress.</li>
                 
                    <li class="list-group-item">📌 Institutions can evaluate learners quickly and effectively.</li>
                </ul>

                <h3 class="mt-4 text-success">✨ What Makes Us Unique?</h3>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item">🎓 Smart Quizzes – Interactive and engaging.</li>
                    <li class="list-group-item">⚡ Instant Results – Quick feedback with insights.</li>
                    <li class="list-group-item">📊 Progress Tracking – Personalized dashboards.</li>
                    <li class="list-group-item">📱 Mobile-Friendly – Learn anywhere, anytime.</li>
                    <li class="list-group-item">🔒 Secure & Reliable – Safe login and data handling.</li>
                </ul>

                <h3 class="mt-4 text-success">👩‍🎓 Who Is It For?</h3>
                <p>
                    Our platform is designed for <strong>everyone in the education ecosystem</strong>:  
                </p>
                <ul>
                    <li><strong>Students</strong> – To prepare for exams and practice daily.</li>
                  
                    <li><strong>Institutions</strong> – To manage digital learning activities efficiently.</li>
                </ul>

                <h3 class="mt-4 text-success">🏆 Benefits of Using Online Quiz System</h3>
                <ul>
                    <li>Easy access to quizzes from anywhere.</li>
                    <li>Track learning progress over time.</li>
                    <li>Secure login and personalized dashboard.</li>
                    <li>Motivation boost through instant results.</li>
                    <li>Paperless & eco-friendly solution.</li>
                </ul>

                <h3 class="mt-4 text-success"> Why Choose Us?</h3>
                <p>
                    Because we don’t just provide quizzes –  
                     We provide <strong>confidence</strong>.  
                     We provide <strong>growth</strong>.  
                     We provide a <strong>smarter way to learn</strong>.  
                </p>

                <div class="alert alert-primary mt-4 rounded-4 shadow-sm">
                    <h5 class="fw-bold">💡 Our Promise</h5>
                    <p class="mb-0">
                        At Online Quiz , we promise to keep learning simple, engaging, and effective.  
                        We are committed to providing a <strong>secure, fast, and reliable</strong> platform where 
                        education becomes a journey of growth and success.  
                    </p>
                </div>

                <div class="text-center mt-5">
                    <h4 class="fw-bold text-secondary"> Smart Learning. Instant Results. Lasting Growth.</h4>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Include common footer
include("includes/footer.php");
?>
