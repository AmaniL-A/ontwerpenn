<?php
use PHPUnit\Framework\TestCase;
use App\Models\Fiets;
use PDO;
use PDOStatement;

class FietsTest extends TestCase {

    public function testCreate() {
        // Mock PDOStatement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([
                 ':merk' => 'Gazelle',
                 ':type' => 'Stadsfiets',
                 ':prijs' => 799.99
             ]);

        // Mock PDO
        $pdo = $this->createMock(PDO::class);
        $pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);
        $pdo->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        // Test Fiets class
        $fiets = new Fiets($pdo);
        $id = $fiets->create('Gazelle', 'Stadsfiets', 799.99);

        $this->assertEquals(1, $id);
    }

    public function testRead() {
        $data = ['id' => 1, 'merk' => 'Gazelle', 'type' => 'Stadsfiets', 'prijs' => 799.99];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([':id' => 1]);
        $stmt->expects($this->once())
             ->method('fetch')
             ->with(PDO::FETCH_ASSOC)
             ->willReturn($data);

        $pdo = $this->createMock(PDO::class);
        $pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $fiets = new Fiets($pdo);
        $result = $fiets->read(1);

        $this->assertEquals($data, $result);
    }

    public function testUpdate() {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([
                 ':merk' => 'Batavus',
                 ':type' => 'Mountainbike',
                 ':prijs' => 999.99,
                 ':id' => 1
             ])
             ->willReturn(true);

        $pdo = $this->createMock(PDO::class);
        $pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $fiets = new Fiets($pdo);
        $result = $fiets->update(1, 'Batavus', 'Mountainbike', 999.99);

        $this->assertTrue($result);
    }

    public function testDelete() {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->with([':id' => 1])
             ->willReturn(true);

        $pdo = $this->createMock(PDO::class);
        $pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $fiets = new Fiets($pdo);
        $result = $fiets->delete(1);

        $this->assertTrue($result);
    }
}
