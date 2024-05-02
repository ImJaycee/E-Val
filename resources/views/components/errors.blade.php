@if(session()->has('error'))
<p class="text-sm text-red-500 text-center" id="errorAlert">
  {{session('error')}}
</p>

@endif
{{-- x-data="{show : true}" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:leave="transition ease-in duration-500" --}}
<script>
    // Function to remove the alert after 5 seconds
    function removeAlert() {
      const errorAlert = document.getElementById("errorAlert");
      if (errorAlert) {
        errorAlert.remove();
      }
    }
  
    // Set a timeout to call the function after 5 seconds (5000 milliseconds)
    setTimeout(removeAlert, 5000);
    
  </script>