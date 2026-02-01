# 📸 EventIntelligence AI | Smart Event Gallery

**EventIntelligence AI** is a cutting-edge solution for managing and exploring photo galleries in large-scale events such as festivals, conferences, corporate gatherings, and social activations.

Unlike traditional galleries, this platform leverages **Convolutional Neural Networks (CNNs)** to index and distribute visual content in a personalized and instantaneous manner through facial biometrics.

---

## 🧠 The AI Exploration

The core of this project lies in **decentralized computer vision**. Instead of processing images on a heavy server, all recognition logic is executed **Client-Side** using the **TensorFlow.js** engine, ensuring scalability, privacy, and performance.

### 🔬 Implementation Details

#### 1️⃣ Landmark Detection
- Uses the `ssdMobilenetv1` model to locate faces in each uploaded image.
- Detects **68 facial landmarks** to accurately align faces, ensuring robustness against head tilt, rotation, or partial occlusion.

#### 2️⃣ Face Descriptor Extraction (Vectorization)
- Each detected face is converted into a **biometric descriptor**.
- This descriptor is a vector of **128 floating-point values** representing the unique mathematical signature of the face.
- Once vectorized, images become **searchable data**, without reprocessing pixels.

#### 3️⃣ Mass Multi-Face Indexing
- Supports **multi-face detection per image**.
- During upload, all faces present are detected and indexed.
- Descriptors are stored as a **JSON array** inside a MySQL `LONGTEXT` field, allowing scalable indexing without schema complexity.

#### 4️⃣ Matching Algorithm (Euclidean Distance)
- Photo retrieval uses `faceapi.FaceMatcher`.
- The system compares the descriptor generated during the user's **Neural Scan** with thousands of stored vectors.
- A confidence threshold of **0.6** is applied, balancing recall and precision while minimizing false positives.

---

## 🚀 Premium Features

- 🧬 **Neural Scan (Real-time Biometrics)** – Facial recognition via webcam with a futuristic UI and instant analysis.
- 📦 **Smart Selection & Batch Download** – Select multiple photos and download them as a single optimized `.zip` archive.
- 📲 **Web Share API Integration** – Native mobile sharing to social media platforms with zero friction.
- ⚡ **Lightweight Infrastructure** – PHP/MySQL backend stores only image paths and vectors, while all AI computation runs on the client's GPU.

---

## 🛠️ System Configuration

### 📊 Database Schema (MySQL)

```sql
CREATE DATABASE event_gallery;
USE event_gallery;

CREATE TABLE fotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    descriptor LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

###📁 Project Structure
text
├── index.html
├── api/
│   ├── upload.php
│   └── photos.php
├── config/
│   └── database.php
├── uploads/
└── README.md


✨ Vision
This project transforms traditional photo galleries into a personalized AI-powered discovery experience, merging computer vision, biometrics, and modern web technologies.

🧠 Tech Stack
TensorFlow.js - Machine learning framework

Face API - Facial recognition library

React (SPA) - Frontend framework

PHP - Backend language

MySQL - Database

Web Share API - Native sharing capabilities

Client-Side GPU Acceleration - Performance optimization

📌 Built for scalability, privacy, and real-world event environments.

