<style>
    :root {
        --brand-black: #0b0b0b;
        --brand-green: #0d7a19;
        --brand-green-dark: #075012;
        --brand-yellow: #ffd34d;
        --brand-white: #ffffff;
        --soft-bg: #f4f6f4;
    }

    .login-shell {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background:
            radial-gradient(circle at top left, rgba(255, 255, 255, 0.16), transparent 26%),
            radial-gradient(circle at bottom right, rgba(255, 255, 255, 0.08), transparent 24%),
            linear-gradient(135deg, #0d7a19 0%, #075012 100%);
    }

    .login-card {
        width: 100%;
        max-width: 520px;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 24px 70px rgba(11, 11, 11, 0.14);
        background: #fff;
        border: 1px solid rgba(13, 122, 25, 0.10);
    }

    .login-form-wrap {
        padding: 34px 30px 30px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfcfb 100%);
    }

    .login-brand {
        flex-direction: column;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 0 20px;
    }

    .login-brand img {
        width: min(92%, 280px);
        max-width: 280px;
        height: auto;
        object-fit: contain;
    }

    .login-brand h2 {
        display: none;
    }

    .login-brand span {
        display: none;
    }

    .login-form-wrap .form-control {
        height: 48px;
        border-radius: 12px;
        padding-left: 44px;
        border-color: #d7dfd7;
        box-shadow: none;
    }

    .login-form-wrap .form-control:focus {
        border-color: var(--brand-green);
        box-shadow: 0 0 0 3px rgba(13, 122, 25, 0.10);
    }

    .login-form-wrap .form-group {
        position: relative;
        margin-bottom: 18px;
    }

    .login-form-wrap .form-group .fa {
        position: absolute;
        top: 14px;
        left: 16px;
        color: var(--brand-green);
        z-index: 3;
    }

    .login-submit {
        margin-top: 8px;
    }

    .login-submit .btn {
        height: 48px;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 0.3px;
        border: 0;
        background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-green-dark) 100%);
        box-shadow: 0 12px 24px rgba(13, 122, 25, 0.22);
    }

    .login-submit .btn:hover {
        filter: brightness(1.02);
    }

    .login-footnote {
        margin-top: 16px;
        font-size: 12px;
        color: #6b726b;
        text-align: center;
    }

    .remember-group {
        margin-bottom: 4px;
    }

    .remember-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #4a554a;
        cursor: pointer;
        user-select: none;
    }

    .remember-label input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--brand-green);
        cursor: pointer;
    }

    @media (max-width: 767px) {
        .login-card {
            border-radius: 18px;
        }

        .login-form-wrap {
            padding: 22px 16px 24px;
        }

        .login-shell {
            padding: 12px;
        }

        .login-brand {
            margin-bottom: 18px;
        }

        .login-brand img {
            width: min(92%, 240px);
        }
    }
</style>

<div class="login-shell">
    <div class="login-card">
        <div class="login-form-wrap">
            <div class="login-brand">
                <img src="vistas/img/imglogin/logoavicolajb.png" alt="Avícola JB">
            </div>

            <form method="post" autocomplete="off">
                <div class="form-group has-feedback">
                    <i class="fa fa-user"></i>
                    <input type="text" class="form-control" name="usuario" placeholder="Usuario" value="<?php echo isset($_COOKIE["usuario_recordado"]) ? htmlspecialchars($_COOKIE["usuario_recordado"]) : ""; ?>" required>
                </div>

                <div class="form-group has-feedback">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>

                <div class="form-group remember-group">
                    <label class="remember-label">
                        <input type="checkbox" name="recuerdame" value="1" <?php if(isset($_COOKIE["usuario_recordado"])) echo "checked"; ?>>
                        <span class="checkmark"></span>
                        Recuérdame
                    </label>
                </div>

                <div class="login-submit">
                    <button type="submit" class="btn btn-success btn-block">Entrar</button>
                </div>

                <?php
                $login = ControladorUsuarios::ctrIngresoUsuario();
                ?>
            </form>

        </div>
    </div>
</div>
