<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background:
                radial-gradient(1000px 400px at 10% -10%, rgba(13, 110, 253, .10), transparent 60%),
                radial-gradient(900px 400px at 110% 10%, rgba(25, 135, 84, .10), transparent 60%),
                #f6f8fb;
            min-height: 100vh;
        }
        .navbar-app { background: linear-gradient(90deg, #0d1117, #1b2430); }
        .brand-icon {
            width: 36px; height: 36px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, .14);
            font-size: 1.1rem;
        }
        .card-custom {
            border-radius: 1.25rem;
            box-shadow: 0 1rem 2.5rem rgba(16, 24, 40, .08);
        }
        .header-icon {
            width: 54px; height: 54px;
            border-radius: 14px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            background: rgba(13, 110, 253, .12);
            color: #0d6efd;
            flex-shrink: 0;
        }
        .table > :not(caption) > * > * { padding: .9rem 1rem; }
        .year-badge {
            min-width: 74px;
            display: inline-flex;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark navbar-app">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/mvc-fast-track/students">
                <span class="brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
                Student Management
            </a>
            <span class="navbar-text text-white-50 d-none d-md-inline">PHP MVC Practice</span>
        </div>
    </nav>

    <main class="container py-5">
        <!-- Success flash message -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success d-flex align-items-center gap-2 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
        <?php endif; ?>
        <!--  Error Messagess-->
        <?php if(!empty($_SESSION['errors']['general'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_SESSION['errors']['general'], ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <span class="header-icon"><i class="bi bi-people-fill"></i></span>
                <div>
                    <h1 class="h2 fw-bold mb-1">Students</h1>
                    <p class="text-secondary mb-0">Manage student information in one place.</p>
                </div>
            </div>
            <!-- FIX: real link to the create page instead of a disabled button -->
            <a href="/mvc-fast-track/students/create" class="btn btn-primary px-4">
                <i class="bi bi-person-plus me-1"></i> Add Student
            </a>
        </div>

        <div class="card border-0 shadow-sm card-custom">
            <div class="card-header bg-white py-3 rounded-top-4">
                <h2 class="h5 mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-table text-primary"></i> Student Records
                </h2>
            </div>
            <div class="card-body p-0">
                <?php if (empty($students)): ?>
                    <div class="text-center py-5 px-3">
                        <i class="bi bi-inbox display-3 text-secondary opacity-50"></i>
                        <h3 class="h5 mt-3">No Students Yet</h3>
                        <p class="text-secondary mb-3">Student records will appear here once added.</p>
                        <a href="/mvc-fast-track/students/create" class="btn btn-outline-primary btn-sm px-3">
                            <i class="bi bi-plus-lg me-1"></i> Add your first student
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">#</th>
                                    <th scope="col"><i class="bi bi-person me-1 text-secondary"></i>Name</th>
                                    <th scope="col"><i class="bi bi-envelope me-1 text-secondary"></i>Email</th>
                                    <th scope="col"><i class="bi bi-journal-bookmark me-1 text-secondary"></i>Course</th>
                                    <th scope="col"><i class="bi bi-123 me-1 text-secondary"></i>Year Level</th>
                                    <th scope="col"><i class="bi bi-calendar3 me-1 text-secondary"></i>Enrolled</th>
                                    <th scope="col"></i>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td class="ps-4 fw-semibold text-secondary"><?= (int)$student['id'] ?></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><span class="badge text-bg-light border"><?= htmlspecialchars($student['course'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                        <td>
                                            <span class="badge year-badge bg-primary-subtle text-primary-emphasis">
                                                Year <?= (int)$student['year_level'] ?>
                                            </span>
                                        </td>
                                        <td class="text-secondary small">
                                            <?= htmlspecialchars(date('M j, Y', strtotime($student['created_at'])), ENT_QUOTES, 'UTF-8') ?>
                                        </td>
                                        <td>
                                            <form action="/mvc-fast-track/students/delete" method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this student?')">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"> 
                                                <input type="hidden" name="id" value="<?= (int) $student['id'] ?>">
                                                
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                <a href="/mvc-fast-track/students/edit?id=<?= (int) $student['id'] ?>" class="btn btn-outline-primary">Edit</a>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-white text-secondary small rounded-bottom-4 d-flex justify-content-between align-items-center">
                <span><i class="bi bi-collection me-1"></i> Total records: <?= count($students) ?></span>
                <span class="d-none d-md-inline"><i class="bi bi-shield-lock me-1"></i> MVC Fast Track &copy; <?= date('Y') ?></span>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>