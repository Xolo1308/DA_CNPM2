<?php
include('include/main.php'); 
include('include/header.php');
include('include/sidebar.php');
include('../../controller/kn_data.php');


$sql = "SELECT j.*, c.name
        FROM jobs j
        JOIN companies c ON j.company_id = c.company_id
       ORDER BY j.job_id ASC";
$result = $conn->query($sql);
?>

<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      <h2 class="mt-4">📋 Duyệt tin tuyển dụng</h2>
      <table class="table table-bordered mt-3">
        <thead>
          <tr>
            <th>#</th>
            <th>Tên Công ty</th>
            <th>Tiêu đề</th>          
            <th>Mô tả</th>
            <th>Yêu cầu</th>
            <th>Lương</th>
             <th>Vị trí</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['job_id'] ?></td>
             <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['requirements']) ?></td>
            <td><?= htmlspecialchars($row['salary']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
         
            <td>
              <?php if ($row['status'] == 'pending'): ?>
                <span class="badge bg-warning">Chờ duyệt</span>
              <?php elseif ($row['status'] == 'approved'): ?>
                <span class="badge bg-success">Đã duyệt</span>
              <?php else: ?>
                <span class="badge bg-danger">Từ chối</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="../../controller/job_approve.php?id=<?= $row['job_id'] ?>&action=approve" 
                 class="btn btn-success btn-sm" 
                 onclick="return confirm('Bạn có chắc chắn muốn DUYỆT tin này?');">Duyệt</a>
              <a href="../../controller/job_approve.php?id=<?= $row['job_id'] ?>&action=reject" 
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Bạn có chắc chắn muốn TỪ CHỐI tin này?');">Từ chối</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>

<?php 
// Đóng kết nối
$conn->close();
include('include/footer.php'); 
?>