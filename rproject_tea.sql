-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2022 at 09:43 AM
-- Server version: 10.3.34-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rproject_tea`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `username`, `password`) VALUES
(1, 'Bg Bim', 'bimaega12', '6ae5c86ad092f60da9ce81ba7f53d710'),
(2, 'testing', 'testing', 'testing');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id_data` int(11) NOT NULL,
  `nama_file` varchar(200) DEFAULT NULL,
  `id_enkripsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id_data`, `nama_file`, `id_enkripsi`) VALUES
(39, '358971614414807Hello_world.pdf', 47),
(41, NULL, 49),
(42, NULL, 50),
(43, NULL, 51),
(44, NULL, 52);

-- --------------------------------------------------------

--
-- Table structure for table `dekripsi`
--

CREATE TABLE `dekripsi` (
  `id_dekripsi` int(11) NOT NULL,
  `key` varchar(200) NOT NULL,
  `output` text NOT NULL,
  `nama_file` varchar(250) NOT NULL,
  `id_enkripsi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dekripsi`
--

INSERT INTO `dekripsi` (`id_dekripsi`, `key`, `output`, `nama_file`, `id_enkripsi`) VALUES
(12, '1234567890123456', '<pre>Hello  wor ld</pre>', '284201614415024665741614413673Hello_world.pdf', 47),
(13, 'bimaegafarizky12', '\r\n        <div class=\"text-center\">\r\n            <h3>Data Admin</h3>\r\n        </div>\r\n        <table class=\"table\">\r\n            <thead>\r\n                <tr>\r\n                    <th>No.</th>\r\n                    <th>Nama</th>\r\n                    <th width=\"30%;\">Username</th>\r\n                    <th>Password</th>\r\n                </tr>\r\n            </thead>\r\n            <tbody>\r\n                    <tr>\r\n                        <td>1</td>\r\n                        <td>testing</td>\r\n                        <td>testing</td>\r\n                        <td>testing</td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td>2</td>\r\n                        <td>Bg Bim</td>\r\n                        <td>bimaega12</td>\r\n                        <td>6ae5c86ad092f60da9ce81ba7f53d710</td>\r\n                    </tr></tbody>\r\n        </table>\r\n        ', '40701614454025Data_Enkrip.pdf', 50);

-- --------------------------------------------------------

--
-- Table structure for table `enkripsi`
--

CREATE TABLE `enkripsi` (
  `id_enkripsi` int(11) NOT NULL,
  `key` varchar(200) NOT NULL,
  `output` text DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enkripsi`
--

INSERT INTO `enkripsi` (`id_enkripsi`, `key`, `output`, `id_admin`) VALUES
(37, '93209470239923N8', NULL, 1),
(39, '5234t34v346346g3', NULL, 1),
(40, '23tv23tv23tv23tv', NULL, 1),
(41, '5432v235g2352g23', NULL, 1),
(47, '1234567890123456', 'sN1Mm3KxzhsyhHq/4MONVm8o8et84c2LBeACvdTlCjRmLX3fPgDLyg==', 1),
(49, 'bimamarinirega12', 'KLymx9z6ojYKDYTLy8ZaZ240oDGbb0Ey6pTdX6xgYW+pP0YaUWa6XeZWhMB6T07DYLO61QLcNWv6tNLdZWgYHabIi196tYYFPe7lsT8pPWKCRAJ+od1Ke7tGJDEV48pwLfrSXM6kLu5Bv6sy+6RgkiUPOsOnPl0sL5xXrI01KgAjlTv+8ucBAO/KRc7WelHpM4OBB36FOGsQCjlsgoWiQGUKSySDbOYagwvFFP8/X3A6FfQbhJ0LYySpEur6uG7RJzW1XXsFNeSSqSTw+Czhx9Q5yTg9RuR9sVfbMhOd4CixjwwHzP0sWevZU35vzKBgbZTrWqfEXN6NOf6loJ2d1Dcjb0bE14qdn05a4bIAzsqirw8UtL531OYKT1SyHrqy/QE8OZ5AVhNLwTl1M4sQY86qWw2BsGSDfHRo/nwVtHsdcv3t7v9lHZ8d1hDIy+wl6+///mppFra1WQ8fmzOlx7HaN2jZO5GBUvyNr11w5U1QrqhmdQg9PReQEIU9dz8SbYBda0gvhEkI4S6n1Zb/RqEzLIvpwuRlPS4If/Ob/kQcZOemtWg1mGuTWa8hZN8Xg6ygA/7KnZ9AX3Fwnxcfuj1+RbfYDDntExlPq7TbYnUJ+cs/+0vH4UiUfio3viWfV2jXMJi5un/V4PAedlnfuGZC7auj2JayHcQWg9VB8rSisU4jc8aFAMmRvvo7yEMlibXZvpJHu6QkV/4uKQM+VoNcF9pnTYq+3gyELI4PWi3J42sggf5dmkNT5Of52M9msf1nu11NXrWL3DX1Q5FhN9TkK+RwTHqB4IYBmkvuX8qCV2IDuhpZeEEYfHAX5xyAzCIg8ZkA55tob8mX0pCJs8ZHismP4J85Q/SRib4mkBbfrKKT2N6jPbQGCDVF3B8XIfUFA4rvtUR2xPpNz+HKtXdQyXGXMP2lcK8vE/IBaAAN4RWgT5pADqEFl//7EzuD0sODp9EqTST4uuwSngLVyrMLKUqAlO0pg4DHs8OyoT0RllXC8TIV3JCHIiCA7zm/pZycsx0xV++RPrCg15lce5YK/nwMJarEaP9vWk00Q39tbQk6lo3vGEmw4mxAnHRcaSMb+0nfcgaVxF+FdbNrbn6oAZRrgp4j1tuMxKu/IL8drVSsBihAQHXCqlrJVVLpioCGlNY7Qi39m7fVb2ZdW4RKjGX4Ql6R', 1),
(50, 'bimaegafarizky12', 'uqoJGda2mJ0vjPRn4Yq8s763Tk0JwIevjvUq5SVXDWIHOoXD7pcvhkhk+CDV1IyIJpWCweiyxgFEE6LCT8G8j6dDOCDCL1uyviEBaIq1rA+tmgOF8h683Nckti9D4oxjwCZdYLwCuc9zXwKUX2xWdZZlhlSOFF3ZmQXvc8k7oo/iKKZXqylAswBDEduvuddKYn+rOHOhJ+E425fcndu65YjUYMuWzIzhHWpZlQqPHb1mQrmJn50KPe4gAQYKp02IL+CTfpe8aVJPA9BTu3Xm3AzctTZ4lhtE5ZTQQHRSG3Q/TYtJytJw+AyfTaw37qlYNmE85Be60djOaztGs28GLUqj8ihy/jfwoaNolbguXE0RLyv4NX3iFHcHZHMYCwHh75RxpczTYhWN5hPhAi7UwNxvFOMejxR4sgXZajtIwqMaRQA/TDFnb2E7Hp6duvdw/jRtK8tSFmkB7XYyMRQwlSHE+3d148YHkDAst3hF0fOBd4wv1XjVVfrJ+qdhwp5rk/pbvlArKZarxrI/f/XL/AqWmTPz+CvdiznJpqPg9qLUHQ9ydeXru0m4AwVUB/fmEWvvl5ec96zpaMnYsKcC3yFs2FqHhsqyOi+tVi8r648jIvHcDm+pu/u7JHPD3Q0mq8NRoYwtgyoBxbmkCaqxAv5uuKXLstZM0L2YQKHMYxxnaXpYL0/O7At6ANM46Gki1mrzBa9TBPNFdcjiU6UNgu6892iEG8ZHrf3aqqnMxV97e9/rZR1MZw0q+IjXwQaL2xSx3Vfho75p/n9ijGOrZMvm3N+fW3dlGU6//v2zL6r6SmdY/UNDOqbU/Dn2W5GsNsanozoP259LzplR1WFD8vH8W8zgv3DI8S+GlenfLMdmkrPECPRYUN5p6dnDbBgMFY22RunF/C2+HZ3Q/uSh2lG4j5i5vmzy7dGnSdD7k7oo47uru6qDlDvYLALqrL6lHqUtyrjJG4F5wgsutN7xlacuv2plPv3lJ2xjF7oHkvjOP9jjGERQAxd/YFdwGnhnuSkfjK1WQosEy32c4P5rTIMZRSTEwa9Xy4ro7OTt0k/NML9djGJJSk40J6v7C7v1/5bmdIytC77qgZnCnSgNI20BX+frHijILXK9rNwe4MbZ+42wmNOl6IynpkDImTt064jpv6bc9hk/IzW7S7rf5htK4HotCSBD', 1),
(51, 'fweofewopjfpwjef', 'tzPIhFUzZtfrSXyMMl1+qCnEWNOUvnuuXWdWpyRHvnJeRM9B/5QXbrbHfapbR9LobFzPZXMNcTmcjgGRPk2NqzFiWawFL+mIBs+pkQlDaFKoBteuzDOmSJy6UWTHaMmlcbVA/egFtWQFYnLsTZa0DL6Ckbb7ECqGAGjEhFefYW0ONirE5SrVX3NPGaaSbkPolOlczVeHxmhHUx+aFuoRKXiJKKOoSprijTH01BN1PxbYvY9Sp0IjMUse+V0+6LlGu7rliUefk0wCjSdwi67fwEBaBlk6WolnYg/jVvpkBZYzl6xdQqhZYZEP7RLfdpCEGXhY4f6zEFOVQm/YXVxW5vXI5ZZwMCcKxlA1nM0jtkvHeELTGKnL9EoOFjpgqwR9XvrFxw4uNchRTE857eD9QNDK1B6xvMsDHH4m6m+AN2RV0nbFbUA3pwe4ko9qALH5+8rIclEv/8pmyosQZqDVTHbh9HXVdz7hCDDFLYp0kENvIzv7PepK00pEyqDBV46OLve/95ik2GjWkMId+J7/T2iSosUmdjfX/K6LLA2BRLpK/Icw2OM2TyX0sxP+L29O4GKZC14O/hNl4LjUjMwfkXC/BsoG+QZ6YxgcS53SEYV1mrIBM/9njsfL9jBykz2N/gCtE2qlMXCw9WOSb6m20vVeyGfpsierdR0OU99TAepJPgf8cCkLNnYY/rRQrweL5+XkXx6DQuWfFeerz+mLGhTjHkZcWCzL2EA4toDG8+3RS2C9uHLtLN2MnzMA4zEQaEenyA3k59anpHGDfnHg6QscuRFWqAQBzLHj9p2nUr86xaa8vNxQipsq0aLmjCXDjLaIwIZkwuy+jI97nHa5YafxSKmvbeBkvmXjudDGsRJtUtf43O8Ex0NQwFLr2z6lOpCEKFiL/skgEDs4eaDF0IVjig/aZM9kTjp48xAe+/oQEVkgYMtzH0bWKfsBFo+pWthFN7ZChoKFZYZP4ScPMJpb2Z2kLd0ciINZEx0SbJTdVdOQGuJLMXQtz5CB/ixEg4yN38VxKqVWRhfYquTjijYgtQkLZaWThgYv9iXlsD+jBaEymOoYCPz+MuMMWsPq4D7Ti2nJXMnCmJ3ioGMW9TbE6GkD4ucbEgwDBOMIzloYS14HyExfl1sTdBfHhTZ7uDBhA2wfv71qtFN3qnXzOwrlGcYrqhsZkE5kaWZ+kLKpREIhq0KnczbQx0e7hFtIIOOAuVU5Uhj41LzftpJoNEwFLHD669X431PkGBCQQYUM6qo6rFTKiHXG7XhEqd5crDTOZL1lwdkxkrvNSq+If+8DlJhe8+bVwNT+AVqffjo4OjZDYjg0ptwTtggLWdqRsRG2QbeM9GathMr+9tBfrHw8t+cCkqTUXAgVpRt0Go8Tlb+BA7RFyjH09FEZB3atuP5fVAQl9LA+5CIgLcFtSjNZlGewWxDUJKFFIHwa/HWM+BxqmHfXlc/1aZj+ZRQp', 1),
(52, '1234567891011121', 'PRUjHSNIOYelTBW5223Nd0XcVLZKjirjlZis1MjB0n8lJAVNNACYW1yxv0I2GtZboLSCbtzf+qDxx8Hq/uUcTJuEaI7AG20YfngHKZ5Q3XuYuF/Npjay16sb3qn122v4obocWSLqTVOORGK3GvEbMn31mblj8pP3hoecu+/X9FZ+OY+RfimXJH5MFXGoy5ZbPV6WRsnQnNpQeSu8rdKiNAfY1GzzfTf0rdZF5H+ykVQU/gKfeUu2LIbrHpsbafx9aT0G55f1Uzu0j4dULONPvpEYhWT2lOKZT015T4S9GGHPkTOYTRwTBQoqjeUbiFO93Z4dIyz4WwThk1W9kiYyVgm9t+oP7LR7UN7kRJjcHFmZCDlz/3/bqRDd+CXdTqbtiuqyZPCh68SqB18Pq/Vc8jNVx1Ask2ciPy4K3IoVM0M0JED1ZXbWgIGYM/7v+TSg1ry6giJ1UFPJ6GS20d60FCwn8BIwmr+JiwA6LR8UtrOsE7hu3k0BkEk3dbL4dkO4wTLa5Zh4c3T7BFItvYn8Zuz4or+MwZT3Z5+bcPEjsBRSlyiSitOHmHg37BXTlQumiH8RP+Ip4C+/BLh5kVwKzcupRSQrEbeR1TqRrA5HEEApdRQi7CfU9LxoTchZFTrM0LOvyZi6nnGfTRLT8/lrGy4JRctbPHE9k7mt6yFK6QwyjlPhqaK3X1bSbmOVZkrYmgwehF8FPsOOkhX5ZHAI/0s5wFN1AYbzlmlm52kstvvY/WjHKoor0Z7xUVAxwW/S6FtTLMlgYWpQgBFHxQXR/eaH5vd/AxA5p5SVhza6ZG03+NXxdfg8MWITyam5RSJK0xxzel7kZRPbJfwr9SsPBC0IQcslUnPIOLb8X+Ht3EXJjPKSehXmvZeX2soju89zBtkfE3wn+h20Kofd3foCSEJdSewX/o5cSx11ZKKSPeQSYOFNhCVf/0h7Cmg1XQ6Wzn1nWPz2k5vKbsykuIH80B6m1hqoMmrxdEutW+gKWhv0cfAx+a1sAGggio7yVxRMHIy+btsdQux32GwdIHY35NPdubAHvdDJo6CD9ga4LB+s3pm8UxiUFnr/KDT7wZ2WP2TtjkFW2w67cHsh/+fhmm+CeiYfCptu0wzI0AqO1Sep2tChnlHMNi7LWWQvqhYyix37g0bnJHJryFT9EY07/9P9b6OwlYpl5QuFmJmLALaGWyGcwgGHXEr39sgNzgJoS4O8YShjWqPfT/hUdOrd0h7Z/ejrgXVzde6nvg88HDn7Z27xo4M/8MIpjOmnSDbzM3yZoBn84fufID+AgEfR3nFPzkgni4LDKZ6p1NU6yD4e63goQBTstYTGKEusjfH5IP/ujzgCpPBkBoP2wZHRRFNdXJjzzE4CQDESfZ4L1BBJb3PAaEBU1wDGWJwatxugTZBCOa+Vaqter1DxfRHMbk+T7EFG6ZbUMlNYQHcgdTACXTAwiCZXhqo6av2uf5w6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id_konfigurasi` int(11) NOT NULL,
  `logo_sistem` varchar(300) NOT NULL,
  `nama_sistem` varchar(200) NOT NULL,
  `pembuat_sistem` varchar(200) NOT NULL,
  `panduan` text NOT NULL,
  `tentang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konfigurasi`
--

INSERT INTO `konfigurasi` (`id_konfigurasi`, `logo_sistem`, `nama_sistem`, `pembuat_sistem`, `panduan`, `tentang`) VALUES
(1, '688821614003949fernando-hernandez-JdoofvUDUwc-unsplash.jpg', 'Sistem Tiny Encryption Algoritm', 'Dessy', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore asperiores nobis deleniti ipsum iure eos numquam debitis aliquid tempore vero veritatis magni quisquam possimus, cum eligendi. Eius, optio debitis amet quibusdam veritatis, nemo nesciunt voluptatibus nobis consequatur officia molestiae, maiores vitae error ipsum mollitia voluptate explicabo repudiandae incidunt officiis deserunt sequi eaque sapiente. Officiis id quaerat odit recusandae enim ea doloribus quia minima, nesciunt perferendis nihil obcaecati architecto ut. Quaerat laudantium ipsam accusamus quas ut voluptas distinctio molestiae autem ratione voluptatem dolorum a sit corporis aliquid quis, rerum ex officiis iusto? Nam amet at rerum tenetur quia. Explicabo, provident similique?</p>\r\n', '<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus, quae! Quae est eum similique nobis ullam in ut totam laboriosam harum! Ipsum est amet consequuntur. Vel id eum provident eligendi in temporibus excepturi aspernatur aliquid. Numquam porro sapiente, sunt magnam ut, esse minus aspernatur quos excepturi tenetur, cum sequi expedita velit necessitatibus ea hic. Possimus repellat qui soluta porro molestiae, rerum maiores facere nisi, sequi nostrum, tenetur esse. Doloremque nemo libero labore ratione, non sequi, eveniet sit aspernatur a recusandae totam praesentium asperiores animi fugiat laboriosam fuga odio excepturi similique, voluptate soluta sint ullam voluptatibus ex commodi! Incidunt ducimus aut, soluta asperiores minus, quod voluptas ipsam, labore magni facere ad exercitationem. Atque et consequuntur aliquam enim impedit porro consectetur dolorum doloribus blanditiis exercitationem rem, aperiam laudantium nulla natus vitae veritatis dolor quibusdam perferendis repellat tempore voluptatum nostrum eaque. Saepe quisquam velit accusantium iste, sit, at porro non commodi quas recusandae inventore magnam voluptas in nesciunt nam possimus quis cum, amet ullam molestiae fuga ut laudantium! Voluptatibus non ratione, repellat est aliquam ipsam perspiciatis? Omnis tempora voluptate odio laborum voluptatum at sapiente exercitationem quia minima! Quasi voluptatum reiciendis reprehenderit illo similique quibusdam eveniet exercitationem, iure magni cumque autem suscipit dolorum error, perspiciatis laboriosam, quis iste? Dolor porro pariatur dolore quaerat et dolorum amet consequuntur placeat, enim maiores sapiente reprehenderit, ducimus debitis numquam fugiat fugit inventore eos! Nostrum labore tempore doloremque dolorum, eos corrupti fugit reiciendis quisquam incidunt atque dolore ipsa repellat, in cumque officia totam rerum nemo, voluptatibus enim iure quis sint reprehenderit? Sequi, accusantium pariatur doloribus dolores molestiae sed? Temporibus vero esse ipsum quam officia quo dignissimos amet a odit vel qui velit consectetur numquam perspiciatis, nemo deleniti omnis sequi quae doloremque, corrupti maxime illo. Iusto quos earum quidem eveniet nisi odio, minus distinctio excepturi officiis atque ducimus ea deleniti.</p>\r\n\r\n<p> </p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `ppdb`
--

CREATE TABLE `ppdb` (
  `id_ppdb` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `nis` varchar(200) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `nik` varchar(30) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ppdb`
--

INSERT INTO `ppdb` (`id_ppdb`, `nama`, `nis`, `jenis_kelamin`, `nik`, `alamat`) VALUES
(2, 'Bg Bim', '9385723759', 'L', '97293879423', 'Medan'),
(3, 'Bg bima ega', '2389472387', 'L', '8329473289', 'Medan,sumut');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id_data`),
  ADD KEY `id_enkripsi` (`id_enkripsi`);

--
-- Indexes for table `dekripsi`
--
ALTER TABLE `dekripsi`
  ADD PRIMARY KEY (`id_dekripsi`),
  ADD KEY `dekripsi_ibfk_1` (`id_enkripsi`);

--
-- Indexes for table `enkripsi`
--
ALTER TABLE `enkripsi`
  ADD PRIMARY KEY (`id_enkripsi`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id_konfigurasi`);

--
-- Indexes for table `ppdb`
--
ALTER TABLE `ppdb`
  ADD PRIMARY KEY (`id_ppdb`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `dekripsi`
--
ALTER TABLE `dekripsi`
  MODIFY `id_dekripsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `enkripsi`
--
ALTER TABLE `enkripsi`
  MODIFY `id_enkripsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id_konfigurasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ppdb`
--
ALTER TABLE `ppdb`
  MODIFY `id_ppdb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`id_enkripsi`) REFERENCES `enkripsi` (`id_enkripsi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dekripsi`
--
ALTER TABLE `dekripsi`
  ADD CONSTRAINT `dekripsi_ibfk_1` FOREIGN KEY (`id_enkripsi`) REFERENCES `enkripsi` (`id_enkripsi`) ON DELETE CASCADE;

--
-- Constraints for table `enkripsi`
--
ALTER TABLE `enkripsi`
  ADD CONSTRAINT `enkripsi_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
