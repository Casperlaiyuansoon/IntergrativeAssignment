<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- Define template for the root element -->
    <xsl:template match="/">
        <html>
            <head>
                <title>Notification List</title>
                <style>
                    /* General styling */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        color: #333;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 80%;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                    }
                    table, th, td {
                        border: 1px solid #ddd;
                    }
                    th, td {
                        padding: 10px;
                        text-align: left;
                    }
                    th {
                        background-color: #007bff;
                        color: #fff;
                    }
                    tr:nth-child(even) {
                        background-color: #f2f2f2;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Filtered Notifications</h1>
                    <xsl:if test="not(/notifications/notification)">
                        <p>No notifications match the selected filter.</p>
                    </xsl:if>
                    <xsl:if test="/notifications/notification">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer ID</th>
                                    <th>Promotion ID</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <xsl:for-each select="/notifications/notification">
                                    <tr>
                                        <td><xsl:value-of select="id"/></td>
                                        <td><xsl:value-of select="user_id"/></td>
                                        <td><xsl:value-of select="promotion_id"/></td>
                                        <td><xsl:value-of select="message"/></td>
                                        <td><xsl:value-of select="status"/></td>
                                        <td><xsl:value-of select="created_at"/></td>
                                    </tr>
                                </xsl:for-each>
                            </tbody>
                        </table>
                    </xsl:if>
                </div>
            </body>
        </html>
    </xsl:template>

    </xsl:stylesheet>
