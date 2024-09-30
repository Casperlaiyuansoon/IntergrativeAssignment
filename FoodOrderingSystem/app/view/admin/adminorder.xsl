<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <head>
                <title>Order List</title>  
            </head>
            <body>
                
                <table border="1">
                    <tr bgcolor="#9acd32">
                        <th>Order No</th>
                        <th>User Email</th>
                        <th>Total Amount</th>
                        <th>Order Date and Time</th>
                        <th>Status</th>
                    </tr>
                    <xsl:for-each select="//order">
                        <tr>
                            <td><xsl:value-of select="@id"/>
                            </td>
                            <td>
                                <xsl:value-of select="user"/>
                            </td>
                            <td>
                                <xsl:value-of select="amount"/>
                            </td>
                            <td>
                                <xsl:value-of select="time"/>
                            </td>
<td>
                            <xsl:choose>
                                <xsl:when test="status = 'Delivered' or status = 'SUCCESS'">
                                    <span style="background-color: #8de02c; color: white; padding: 5px; border-radius: 3px;">
                                        <xsl:value-of select="status"/>
                                    </span>
                                </xsl:when>
                                <xsl:when test="status = 'PENDING'">
                                    <span style="background-color: orange; color: white; padding: 5px; border-radius: 3px;">
                                        <xsl:value-of select="status"/>
                                    </span>
                                </xsl:when>
                                <xsl:when test="status = 'PROCESSING'">
                                    <span style="background-color: blue; color: white; padding: 5px; border-radius: 3px;">
                                        <xsl:value-of select="status"/>
                                    </span>
                                </xsl:when>
                                <xsl:otherwise>
                                    <span style="background-color: gray; color: white; padding: 5px; border-radius: 3px;">
                                        <xsl:value-of select="status"/>
                                    </span>
                                </xsl:otherwise>
                            </xsl:choose>
                        </td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>

