# TaskFlow (Office Boy / OB Monitoring Study Case)

## Project Overview

This repository contains the solution for the **OB Monitoring** study case. The project is designed to provide a comprehensive system for tracking and managing **On-Boarding (OB)** processes, primarily focusing on streamlining the workflow, enhancing transparency, and improving the monitoring of new hires or assets as they go through the onboarding stages. The system allows users to track the status, assigned personnel, deadlines, and relevant documents associated with each OB task or entity.

---

## 🛠️ Techstack

This project was developed using a modern, robust, and scalable technology stack:

| Category | Technology | Description |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel** | A powerful PHP web application framework providing elegant syntax and essential tools for rapid development. |
| **Frontend Styling** | **Tailwind CSS** | A highly customizable, low-level CSS framework that gives developers all the building blocks they need to create bespoke designs. |
| **Database** | **MySQL** | A reliable and widely-used open-source relational database management system for persistent data storage. |

### Key Libraries/Dependencies:

* **Laravel Eloquent:** Object-Relational Mapper (ORM) for simplified database interaction.
* **Laravel Blade:** Templating engine for clean and reusable view files.
* *(Add any other specific third-party libraries used here, or remove this list if none were used.)*

---

## ✨ Features

The OB Monitoring system includes the following core functionalities:

* **Task/Entity Tracking:** Ability to create, view, update, and delete OB entities (e.g., New Employee, New Asset).
* **Status Management:** Clear and visual indicators for the current status of each OB entity (e.g., Pending, In Progress, Completed, Delayed).
* **User/Assignee Management:** Functionality to assign specific users (e.g., HR, IT, Manager) responsible for different stages of the onboarding process.
* **Progress Dashboard:** A centralized dashboard providing an overview of all ongoing OB processes, key metrics, and completion rates.
* **Timeline/History:** A log or timeline detailing the changes and progression history of each OB entity.
* **Search & Filtering:** Robust searching and filtering capabilities to quickly locate specific records based on status, assignee, or date.

---

## 💡 Solution Approach

The solution provided for the OB Monitoring case study focuses on creating a **Single Source of Truth** and a **Structured Workflow**.

1.  **MVC Architecture (Laravel):**
    * Implemented a clear **Model-View-Controller** structure using Laravel to ensure **maintainability** and **scalability**.
    * Database schema (Models) was designed to effectively capture the relationships between OB entities, their statuses, and assigned users.
2.  **User Experience (Tailwind CSS):**
    * Used Tailwind CSS to build a responsive and intuitive user interface, prioritizing **visual clarity** and **ease of navigation** on the tracking dashboard. The utility-first approach allowed for rapid development of status indicators and visual hierarchy.
3.  **Data Persistence (MySQL):**
    * Utilized MySQL for reliable data storage. Database migrations were used to version control the schema, ensuring a consistent setup.
4.  **Workflow Implementation:**
    * The core logic manages state transitions (e.g., moving an entity from 'Pending' to 'In Progress' upon specific user actions) to enforce the predefined onboarding steps. This provides the necessary **control** and **auditability** for the monitoring process.

By combining the robustness of Laravel with the styling power of Tailwind CSS and the reliability of MySQL, the solution delivers an efficient, transparent, and user-friendly system to effectively monitor and manage the On-Boarding operations.

---

## 🚀 Getting Started (Optional Section)

To run this project locally, follow these steps:

1.  **Clone the repository:**
    ```bash
    git clone [Your_Repo_URL]
    cd OB-Monitoring
    ```
2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    npm run dev # or npm run build
    ```
3.  **Setup Environment and Database:**
    * Copy the example environment file: `cp .env.example .env`
    * Update your database credentials in the `.env` file.
4.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```
5.  **Run Migrations and Seeding (if applicable):**
    ```bash
    php artisan migrate --seed
    ```
6.  **Start the local development server:**
    ```bash
    php artisan serve
    ```
    The application will be accessible at `http://127.0.0.1:8000`.
