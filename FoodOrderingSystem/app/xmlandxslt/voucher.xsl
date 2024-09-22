
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>
    
    <xsl:template match="/vouchers">
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    padding: 0;
                    background-color: #f9f9f9;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                th, td {
                    border: 1px solid #ddd;
                    padding: 12px;
                    text-align: center;
                }

                th {
                    background-color: #4CAF50;
                    color: white;
                }

                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }

                tr:hover {
                    background-color: #e9e9e9;
                }

                .delete-btn {
                    color: white;
                    background-color: #f44336;
                    border: none;
                    padding: 5px 10px;
                    cursor: pointer;
                    font-weight: bold;
                    border-radius: 4px;
                }

                .delete-btn:hover {
                    background-color: #d32f2f;
                }

                .edit-btn {
                    color: #4CAF50;
                    text-decoration: none;
                    font-weight: bold;
                    padding: 5px 10px;
                    border: 1px solid #4CAF50;
                    border-radius: 4px;
                    transition: background-color 0.3s ease;
                }

                .edit-btn:hover {
                    background-color: #4CAF50;
                    color: white;
                }
            </style>
        </head>
        <body>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Promotion ID</th>
                        <th>Expiration Date</th>
                        <th>Discount (%)</th>
                        <th>Max Uses</th>
                        <th>Times Used</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <xsl:for-each select="voucher">
                        <xsl:sort select="discount_percentage" order="descending"/>
                        <tr>
                            <td><xsl:value-of select="code"/></td>
                            <td><xsl:value-of select="promotion_id"/></td>
                            <td><xsl:value-of select="expiration_date"/></td>
                            <td><xsl:value-of select="discount_percentage"/></td>
                            <td><xsl:value-of select="max_uses"/></td>
                            <td><xsl:value-of select="times_used"/></td>
                            <td>
                                <form method="POST" action="../controllers/VoucherController.php" style="display:inline;">
                                    <input type="hidden" name="id" value="{id}"/>
                                    <input type="submit" name="delete_voucher" value="Delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this voucher?');"/>
                                </form>
                                <a href="edit_voucher.php?id={id}" class="edit-btn">Edit</a>
                            </td>
                        </tr>
                    </xsl:for-each>
                </tbody>
            </table>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
