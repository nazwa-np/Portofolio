const express = require("express");
const { param, body, validationResult } = require("express-validator");
const registerValidator = require('./middleware/register-validator');
const errorHandler = require('./middleware/error-handler');
const jwt = require('jsonwebtoken'); 
const bcrypt = require("bcrypt");
const secretKey = 'your-secret-key';
const USERS = require("./item");
const app = express();

const user = []; // Array untuk menyimpan pengguna yang telah mendaftar

// Fungsi untuk mendapatkan pengguna berdasarkan email
const getUserByEmail = (email) => {
    return USERS.find(user => user.email === email);
};

app.use(express.json());

app.post('/auth/register', registerValidator, (req, res) => {
    const validateResult = validationResult(req);
    if (!validateResult.isEmpty()) {
        return res.status(400).json({
            message: "Validation Error",
            detail: validateResult.array()
        });
    }

    const { email, password } = req.body;

    // Cek apakah email sudah terdaftar
    if (getUserByEmail(email)) {
        return res.status(400).json({
            message: "Email already registered.",
        });
    }

    // Buat ID unik untuk pengguna
    const userId = USERS.length + 1;

    // Hash kata sandi menggunakan bcrypt
    const hashedPassword = bcrypt.hashSync(password, 10);

    // Tambahkan pengguna ke daftar pengguna
    const newUser = {
        id: userId,
        email: email,
        password: hashedPassword
    };

    USERS.push(newUser);

    return res.status(201).json({
        message: "Success",
    });
});

app.post('/auth/login', (req, res) => {
    const { email, password } = req.body;
    
    // Cari pengguna berdasarkan email
    const user = getUserByEmail(email);

    // Jika pengguna tidak ditemukan, kirim respons gagal
    if (!user) {
        return res.status(400).json({
            message: "Email not found.",
        });
    }

    // Perbandingan kata sandi
    const passwordMatch = bcrypt.compareSync(password, user.password);

    if (!passwordMatch) {
        return res.status(400).json({
            message: "Login Failed"
        });
    }

    // Jika email dan kata sandi cocok, buat token JWT
    const token = jwt.sign({ id: user.id }, secretKey);
    
    return res.status(200).json({
        message: "Success",
        data: {
            token: token
        }
    });
});

app.get('/auth/users', (req, res) => {
    if (USERS.length === 0) {
        return res.status(404).json({
            message: "User not found"
        });
    }

    return res.status(200).json({
        message: "Success",
        data: USERS
    });
});

app.get('/auth/users/:userId', [
    param('userId').isInt().toInt(),
], (req, res) => {
    const validateResult = validationResult(req);
    
    // Cek apakah terjadi kesalahan validasi
    if (!validateResult.isEmpty()) {
        return res.status(400).json({
            message: "Validation Error",
            detail: validateResult.array()
        });
    }

    const userId = req.params.userId; // Mengambil ID pengguna dari parameter URL sebagai bilangan bulat
    
    // Cari pengguna berdasarkan ID
    const user = USERS.find(user => user.id === userId);

    // Jika pengguna ditemukan, kirim respons dengan data pengguna
    if (user) {
        return res.status(200).json({
            message: "Success",
            data: user
        });
    }

    // Jika pengguna tidak ditemukan, kirim respons dengan pesan error
    return res.status(404).json({
        message: "User not found."
    });
});

app.use(errorHandler);

app.listen(3500, () => {
    console.log(`app start at http://localhost:3500`);
});