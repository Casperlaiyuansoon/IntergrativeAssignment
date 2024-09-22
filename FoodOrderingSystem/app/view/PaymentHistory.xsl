<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <html>
            <head>
                <title>Payment History</title>
                <style>
                    body {
                        font-family: 'Poppins', sans-serif;
                    }
                    
                    table {
                        width: 100%;
                        table-layout: fixed;
                        border-collapse: collapse;
                    }

                    thead th {
                        position: sticky;
                        top: 0;
                        background-color: #f6f9fc;
                        color: #8493a5;
                        font-size: 15px;
                    }

                    th,
                    td {
                        border-bottom: 1px solid #dddddd;
                        background-color: #ffffff;
                        padding: 10px 20px;
                        word-break: break-all;
                        text-align: center;
                    }

                    td img {
                        height: 60px;
                        width: 60px;
                        object-fit: cover;
                        border-radius: 15px;
                        border: 5px solid #ced0d2;
                    }

                    tr:hover td {
                        color: #0298cf;
                        cursor: pointer;
                        background-color: #f6f9fc;
                    }
                </style>
            </head>
            <body>
                <h2>Payment History</h2>
                <table>
                    <tr>
                        <th>Payment ID</th>
                        <th>Payment Amount</th>
                        <th>Payment Method</th>
                        <th>Payment Date</th>
                    </tr>

                    <!-- [not(product = preceding-sibling::order/product)] -->
                    <xsl:for-each select="/payments/payment">
                        <tr>
                            <td><xsl:value-of select="@id" /></td>
                            <td><xsl:value-of select="amount" /></td>
                            <td><xsl:value-of select="method" /></td>
                            <td><xsl:value-of select="payment_date" /></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
