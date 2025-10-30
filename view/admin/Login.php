

<style>
/* === LOGIN FORM STYLING === */
body {
  background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
  font-family: "Poppins", sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  margin: 0;
}

.login-container {
  background: #fff;
  width: 400px;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  padding: 40px 35px;
  text-align: center;
  transition: all 0.3s ease;
}

.login-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
}

.login-container h2 {
  font-weight: 600;
  color: #333;
  margin-bottom: 20px;
}

.login-container .form-group {
  position: relative;
  margin-bottom: 20px;
}

.login-container input {
  width: 100%;
  padding: 12px 15px 12px 45px;
  border: none;
  border-radius: 10px;
  background: #f1f1f1;
  outline: none;
  transition: 0.3s;
  font-size: 15px;
}

.login-container input:focus {
  background: #e8f0fe;
  box-shadow: 0 0 0 2px #2575fc;
}

.login-container .form-group i {
  position: absolute;
  top: 12px;
  left: 15px;
  color: #888;
  font-size: 18px;
}

.login-container button {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 10px;
  background: linear-gradient(135deg, #2575fc, #6a11cb);
  color: #fff;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}

.login-container button:hover {
  background: linear-gradient(135deg, #6a11cb, #2575fc);
  transform: scale(1.03);
}

.login-container .extra-links {
  margin-top: 15px;
}

.login-container .extra-links a {
  color: #2575fc;
  text-decoration: none;
  font-size: 14px;
}

.login-container .extra-links a:hover {
  text-decoration: underline;
}
</style>

<div class="login-container">
  <h2>Đăng nhập</h2>
  <form method="POST" action="controller/login_admin.php">
    <div class="form-group">
      <i class="fa fa-user"></i>
      <input type="text" name="username" placeholder="Tên đăng nhập" required>
    </div>

    <div class="form-group">
      <i class="fa fa-lock"></i>
      <input type="password" name="password" placeholder="Mật khẩu" required>
    </div>

    <button type="submit">Đăng nhập</button>

    <div class="extra-links">
      <a href="#">Quên mật khẩu?</a> | 
     
    </div>
  </form>
</div>


