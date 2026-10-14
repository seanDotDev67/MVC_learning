<?php
    $pageTitle = 'Edit Student';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student | MVC Fast Track</title>
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
        .form-control, .form-select, .input-group-text { border-radius: .65rem; }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: 0;
            color: #6c757d;
            min-width: 44px;
            justify-content: center;
        }
        .form-control:focus, .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .12);
        }
        .invalid-feedback { font-size: .85rem; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark navbar-app">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/mvc-fast-track/students">
                <span class="brand-icon"><i class="bi bi-mortarboard-fill"></i></span>
                Student Management
            </a>
        </div>
    </nav>

    <main class="container py-5" style="max-width: 760px;">
        <a href="/mvc-fast-track/students" class="text-decoration-none d-inline-block mb-3">
            <i class="bi bi-arrow-left me-1"></i> Back to Students
        </a>

        <div class="card border-0 shadow-sm card-custom">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center gap-3 mb-1">
                    <span class="header-icon"><i class="bi bi-pencil-square"></i></span>
                    <div>
                        <h1 class="h3 fw-bold mb-0">Edit Student</h1>
                        <p class="text-secondary mb-0">
                            Updating record #<?= (int)($student['id'] ?? 0) ?>
                        </p>
                    </div>
                </div>

                <hr class="my-4">

                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div><?= htmlspecialchars($errors['general'], ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                <?php endif; ?>

                <form action="/mvc-fast-track/students/update" method="POST" novalidate>
                    <input type="hidden" name="csrf_token"
                           value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="id" value="<?= (int)($student['id'] ?? 0) ?>">

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Full Name</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text"
                                   class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                   id="name" name="name" maxlength="100"
                                   value="<?= htmlspecialchars($old['name'] ?? $student['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                   required>
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email"
                                   class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                   id="email" name="email" maxlength="150"
                                   value="<?= htmlspecialchars($old['email'] ?? $student['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                   required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Course -->
                    <div class="mb-3">
                        <label for="course" class="form-label fw-semibold">Course</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-journal-bookmark"></i></span>
                            <input type="text"
                                   class="form-control <?= isset($errors['course']) ? 'is-invalid' : '' ?>"
                                   id="course" name="course" maxlength="100"
                                   placeholder="e.g. BSIT"
                                   value="<?= htmlspecialchars($old['course'] ?? $student['course'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                   required>
                            <?php if (isset($errors['course'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['course'], ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Year Level -->
                    <div class="mb-4">
                        <label for="year_level" class="form-label fw-semibold">Year Level</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                            <?php $selectedYear = (string)($old['year_level'] ?? $student['year_level'] ?? ''); ?>
                            <select class="form-select <?= isset($errors['year_level']) ? 'is-invalid' : '' ?>"
                                    id="year_level" name="year_level" required>
                                <option value="">Choose year level</option>
                                <?php for ($year = 1; $year <= 4; $year++): ?>
                                    <option value="<?= $year ?>"
                                        <?= $selectedYear === (string)$year ? 'selected' : '' ?>>
                                        Year <?= $year ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <?php if (isset($errors['year_level'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['year_level'], ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2-circle me-1"></i> Save Changes
                        </button>
                        <a href="/mvc-fast-track/students" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center text-secondary small mt-4 mb-0">
            <i class="bi bi-shield-lock me-1"></i> MVC Fast Track &copy; <?= date('Y') ?>
        </p>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>