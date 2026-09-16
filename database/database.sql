
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('student', 'admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(150) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    venue VARCHAR(150) NOT NULL,
    description TEXT
);

CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    department VARCHAR(100) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id),
    UNIQUE KEY unique_student_event (user_id, event_id)
);

-- Sample records: users
INSERT INTO users (id, name, email, role, created_at) VALUES
(1, 'Rahul Patil', 'rahul@gmail.com', 'student', '2026-09-04 17:00:33'),
(2, 'Priya Sharma', 'priya@gmail.com', 'student', '2026-09-04 17:00:33'),
(3, 'Aaditi Nagpure', 'ghf12@gmail.com', 'student', '2026-09-04 17:44:08'),
(4, 'Ishwari Kalbande', 'kklkh@gmail.com', 'student', '2026-09-04 17:46:56'),
(5, 'Yash', 'tamatya12@gmail.com', 'student', '2026-09-05 07:48:30');

-- Sample records: events
INSERT INTO events (id, event_name, description, event_date, event_time, venue) VALUES
(2, 'Tech Fest 2026', 'Annual technical festival', '2026-09-15', '10:00:00', 'College Auditorium'),
(3, 'Cultural Fest 2026', 'College cultural and entertainment event', '2026-09-20', '11:00:00', 'Main Ground'),
(4, 'Sports Day 2026', 'Annual inter-department sports competition', '2026-09-25', '09:00:00', 'College Sports Ground'),
(5, 'Coding Competition', 'Programming and coding competition', '2026-10-05', '10:30:00', 'Computer Lab'),
(6, 'Entrepreneurship Workshop', 'Workshop on startups and entrepreneurship', '2026-10-10', '12:00:00', 'Seminar Hall');

-- Sample records: registrations
INSERT INTO registrations (id, user_id, event_id, department, registration_date) VALUES
(1, 2, 2, 'CSE', '2026-09-04 17:01:23'),
(2, 3, 3, 'AIDS', '2026-09-04 17:44:08'),
(3, 4, 2, 'MBA', '2026-09-04 17:46:56'),
(5, 4, 5, 'MBA', '2026-09-04 18:34:03'),
(9, 5, 4, 'AIML', '2026-09-05 07:48:30');
