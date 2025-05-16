<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516194406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE collection_point DROP client_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE execution_events DROP CONSTRAINT execution_events_order_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE execution_events DROP CONSTRAINT execution_events_route_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_73B2315F8D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_73B2315F34ECB4E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE execution_events DROP order_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE execution_events DROP route_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders DROP CONSTRAINT orders_client_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders DROP CONSTRAINT orders_collection_point_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders DROP CONSTRAINT orders_route_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E52FFDEE19EB6921
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E52FFDEE31A80092
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E52FFDEE34ECB4E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders DROP client_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders DROP collection_point_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders DROP route_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes DROP CONSTRAINT routes_transport_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes DROP CONSTRAINT routes_driver_session_id_fkey
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_32D5C2B39909C13F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_32D5C2B357B6614
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes DROP transport_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes DROP driver_session_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transport RENAME COLUMN eкtransport_capacity TO transport_capacity
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE collection_point ADD client_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transport RENAME COLUMN transport_capacity TO "eкtransport_capacity"
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE execution_events ADD order_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE execution_events ADD route_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE execution_events ADD CONSTRAINT execution_events_order_id_fkey FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE execution_events ADD CONSTRAINT execution_events_route_id_fkey FOREIGN KEY (route_id) REFERENCES routes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_73B2315F8D9F6D38 ON execution_events (order_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_73B2315F34ECB4E6 ON execution_events (route_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders ADD client_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders ADD collection_point_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders ADD route_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders ADD CONSTRAINT orders_client_id_fkey FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders ADD CONSTRAINT orders_collection_point_id_fkey FOREIGN KEY (collection_point_id) REFERENCES collection_point (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE orders ADD CONSTRAINT orders_route_id_fkey FOREIGN KEY (route_id) REFERENCES routes (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E52FFDEE19EB6921 ON orders (client_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E52FFDEE31A80092 ON orders (collection_point_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E52FFDEE34ECB4E6 ON orders (route_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes ADD transport_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes ADD driver_session_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes ADD CONSTRAINT routes_transport_id_fkey FOREIGN KEY (transport_id) REFERENCES transport (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes ADD CONSTRAINT routes_driver_session_id_fkey FOREIGN KEY (driver_session_id) REFERENCES session_drivers_work (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_32D5C2B39909C13F ON routes (transport_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_32D5C2B357B6614 ON routes (driver_session_id)
        SQL);
    }
}
