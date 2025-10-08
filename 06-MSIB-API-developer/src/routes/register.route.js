const express = require('express');
const registerController = require("../controllers/register.controller")
const router = express.Router();

router.post("/register", registerController );
router.get("/register", registerController );

module.exports = router;