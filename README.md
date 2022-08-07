# Employee_App
The employee management app in laravel and vuejs created by Tejas.

# Run the following commands to run the project -

1. composer install
2. npm install
3. npm run dev
4. php artisan serve

# To migrate tables run -

1. php artisan migrate

# OR create table manually by using following query - 

# Query to create employees table -

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Employee_Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Phone` bigint(100) NOT NULL,
  `DOB` date DEFAULT NULL,
  `Image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;