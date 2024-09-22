<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <head>
                <title>Sign Up</title>
                <link rel="stylesheet" href="css/signup.css"/>
            </head>
            <body>
                <div class="hero">
                    <div class="login_form">
                        <h1>Register</h1>
                        <form class="input_box" method="POST" action="">
                            <xsl:for-each select="/form/field">
                                <div>
                                    <label for="{name}">
                                        <xsl:value-of select="label"/>
                                    </label>
                                    <input type="{type}" name="{name}" class="field" placeholder="{placeholder}" id="{name}"/>
                                </div>
                            </xsl:for-each>
                            <button type="submit" class="submit_btn">Register</button>
                        </form>
                        <div class="social_icon">
                            <i class="fa-brands fa-facebook-f"></i>
                            <i class="fa-brands fa-twitter"></i>
                            <i class="fa-brands fa-google"></i>
                        </div>
                        <div class="tag">
                            <span>Already a User?</span>
                            <a href="../../app/view/login.php">Log in</a>
                        </div>
                    </div>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
