 echo '<div class="table" style="text-align: center; margin-top: 50px;">
 <h2>Payment Invoice</h2>
 <br>
 <table style="width:50%; margin: auto;">
 ';
 $sql = "SELECT * FROM payment WHERE payment_id ='$id'";
       $result = mysqli_query($con,$sql);
       while($row = mysqli_fetch_assoc($result)){
      echo '
     <tr>
       <th>Parameters</th>
       <th>Status</th> 
     </tr>
     <tr>
       <td>Payment ID</td>
       <td> ';
                     echo $row['payment_id']; 
        echo '</td>
     </tr>
     <tr>
       <td>Payment Status</td>
       <td>'; 
                     echo $row['payment_status']; 
       
        echo '</td>
     </tr> ';
    echo '
   </table>
 </div>
 <div class="text-center">
 <h8>This is a computer generated invoice. Hence no signature is required.</h8>
 </div>
 ';