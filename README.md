# 📸 EventIntelligence AI | Smart Event Gallery

**EventIntelligence AI** is a cutting-edge solution for managing and exploring photo galleries in large-scale events such as festivals, conferences, corporate gatherings and social activations. Unlike traditional galleries, this platform leverages **Convolutional Neural Networks (CNNs)** to index and distribute visual content in a personalised and instantaneous manner through **facial biometrics**.

## 🧠 AI Exploration
The core of this project lies in **decentralised computer vision**. Instead of processing images on a heavy server, all recognition logic is executed **client-side** using **TensorFlow.js**, ensuring ⚡ scalability, 🔐 privacy and 🚀 high performance through client-side GPU acceleration.

## 🔬 How It Works
Face detection is performed using the **ssdMobilenetv1** model to locate faces in uploaded images. The system detects **68 facial landmarks** to accurately align faces, remaining robust against head tilt, rotation and partial occlusion.

Each detected face is converted into a **biometric descriptor**, represented by a vector of **128 floating-point values** that form the unique mathematical signature of a face. Once vectorised, images become searchable data without the need to reprocess raw pixels.

The platform supports **multi-face indexing**, allowing multiple faces per image. During upload, all detected faces are indexed and stored as **JSON arrays** inside a MySQL **LONGTEXT** field, enabling scalable indexing without introducing database schema complexity.

Photo matching is handled using **faceapi.FaceMatcher** with **Euclidean distance**. The descriptor generated during the user’s **Neural Scan** is compared against thousands of stored vectors, applying a confidence threshold of **0.6** to balance precision and recall while minimising false positives.

## 🚀 Premium Features
🧠 **Neural Scan (Real-Time Biometrics)** – Webcam-based facial recognition with a futuristic UI and instant analysis  
📦 **Smart Selection & Batch Download** – Select multiple photos and download them as a single optimised ZIP archive  
📲 **Web Share API Integration** – Native mobile sharing to social media platforms with zero friction  
⚡ **Lightweight Infrastructure** – PHP/MySQL backend stores only image paths and biometric vectors while all AI computation runs entirely on the client’s GPU  

## 🛠️ System Configuration

### 🗄️ Database Schema (MySQL)

    CREATE DATABASE event_gallery;
    USE event_gallery;

    CREATE TABLE fotos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        url VARCHAR(255) NOT NULL,
        descriptor LONGTEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

### 📁 Project Structure

    ├── index.html
    ├── api/
    │   ├── upload.php
    │   └── photos.php
    ├── config/
    │   └── database.php
    ├── uploads/
    └── README.md

## ✨ Vision
This project transforms traditional photo galleries into a **personalised AI-powered discovery experience**, merging 👁️ computer vision, 🧬 facial biometrics and 🌐 modern web technologies. It is designed for real-world event environments where **performance, privacy and scalability** are critical.

## 🧠 Tech Stack
TensorFlow.js, Face API, React (SPA), PHP, MySQL, Web Share API and client-side GPU acceleration.

📌 **Built for scalability, privacy and high-performance event environments.**
