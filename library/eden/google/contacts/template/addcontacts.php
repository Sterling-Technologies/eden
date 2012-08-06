<atom:entry xmlns:atom='http://www.w3.org/2005/Atom' xmlns:gd='http://schemas.google.com/g/2005'>
<atom:category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/contact/2008#contact'/>
	<gd:name>
     <gd:givenName><?php echo $givenName; ?></gd:givenName>
     <gd:familyName><?php echo $familyName; ?></gd:familyName>
     <gd:fullName><?php echo $fullName; ?></gd:fullName>
  </gd:name>
  <atom:content type='text'><?php echo $notes; ?></atom:content>
  <gd:email rel='http://schemas.google.com/g/2005#work'
    primary='true'
    address='<?php echo $email; ?>' displayName='<?php echo $fullName; ?>'/> 
  <gd:email rel='http://schemas.google.com/g/2005#home'
    address='<?php echo $email; ?>'/>
  <gd:phoneNumber rel='http://schemas.google.com/g/2005#work'
    primary='true'>
    <?php echo $phoneNumber; ?>
  </gd:phoneNumber>
  <gd:phoneNumber rel='http://schemas.google.com/g/2005#home'>
    <?php echo $phoneNumber; ?>
  </gd:phoneNumber>
  <gd:im address='<?php echo $email; ?>'
    protocol='http://schemas.google.com/g/2005#GOOGLE_TALK'
    primary='true'
    rel='http://schemas.google.com/g/2005#home'/>
  <gd:structuredPostalAddress
      rel='http://schemas.google.com/g/2005#work'
      primary='true'>
    <gd:city><?php echo $city; ?></gd:city>
    <gd:street><?php echo $street; ?></gd:street>
    <gd:region><?php echo $region; ?></gd:region>
    <gd:postcode><?php echo $postCode; ?></gd:postcode>
    <gd:country><?php echo $country; ?></gd:country>
    <gd:formattedAddress>
      <?php echo $street.' '.$city; ?>
    </gd:formattedAddress>
  </gd:structuredPostalAddress>
</atom:entry>