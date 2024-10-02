<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>menu.xsl</title>
            </head>
            <body>           
                <xsl:for-each select="//menu">
                      <xsl:value-of select="@id"/>
                       <xsl:value-of select="name"/>
                       <xsl:value-of select="price"/>
                       <xsl:value-of select="image"/>
                </xsl:for-each>
                
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
