<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:template match="/">
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Discount (%)</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
            <xsl:for-each select="promotions/promotion">
                <tr>
                    <td><xsl:value-of select="title"/></td>
                    <td><xsl:value-of select="description"/></td>
                    <td><xsl:value-of select="discount_percentage"/></td>
                    <td><xsl:value-of select="start_date"/></td>
                    <td><xsl:value-of select="end_date"/></td>
                    <td>
                        <a href="edit_promotion.php?id={id}">Edit</a>
                        <form method="POST" action="../controllers/PromotionControllers.php" style="display:inline;">
                            <input type="hidden" name="id" value="{id}" />
                            <input type="submit" name="delete_promotion" value="Delete" class="delete-btn" />
                        </form>
                    </td>
                </tr>
            </xsl:for-each>
        </table>
    </xsl:template>
</xsl:stylesheet>
