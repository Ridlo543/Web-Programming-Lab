fetch("https://jsonplaceholder.typicode.com/users")
  .then((response) => response.json())
  .then((users) => {
    console.log("Jumlah users:", users.length);

    // Akses properti JSON
    users.forEach((user) => {
      console.log(`Nama: ${user.name}, Email: ${user.email}`);
    });

    // Filter data
    const filteredUsers = users.filter((user) => user.name.startsWith("L"));
    console.log("Users dengan nama berawalan L:", filteredUsers);
  });
