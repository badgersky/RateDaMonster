import os
import psycopg2
from dotenv import load_dotenv

load_dotenv()

TYPE_MAPPING = {
    "monster_energy": 1,
    "monster_ultra": 2,
    "monster_coffee": 3,
    "juice_monster": 4,
    "rehab_monster": 5
}

base_path = "public/img"

def seed_monster_types(conn, type_mapping):
    cur = conn.cursor()
    
    for type_name, type_id in type_mapping.items():
        type_name = type_name.replace('_', ' ')
        cur.execute(
            """
            INSERT INTO monster_types (id, name)
            VALUES (%s, %s)
            ON CONFLICT (id) DO UPDATE SET name = EXCLUDED.name;
            """,
            (type_id, type_name)
        )
    
    cur.execute("SELECT setval('monster_types_id_seq', (SELECT MAX(id) FROM monster_types));")
    conn.commit()
    cur.close()

def import_monsters():
    try:
        conn = psycopg2.connect(
            host=os.getenv("DB_HOST", "localhost"),
            port=os.getenv("DB_PORT", 5433),
            database=os.getenv("POSTGRES_DB"),
            user=os.getenv("POSTGRES_USER"),
            password=os.getenv("POSTGRES_PASSWORD")
        )
        cur = conn.cursor()

        seed_monster_types(conn, TYPE_MAPPING)

        for folder_name, type_id in TYPE_MAPPING.items():
            folder_path = os.path.join(base_path, folder_name)
            
            if not os.path.exists(folder_path):
                continue

            for file_name in os.listdir(folder_path):
                if file_name.lower().endswith(('.png')):
                    monster_name = os.path.splitext(file_name)[0].replace('_', ' ').title()
                    image_url = os.path.join(folder_path, file_name)
                    
                    description = (
                        f"Discover the unique taste of {monster_name}! "
                        f"This energy drink from the {folder_name.replace('_', ' ')} category "
                        f"is the perfect combination of intense flavor and a solid energy boost. "
                        f"Every sip delivers a one-of-a-kind taste experience that will keep you energized and ready to take on the entire day."
                    )

                    cur.execute(
                        """
                        INSERT INTO monsters (name, description, image_url, monster_type_id)
                        VALUES (%s, %s, %s, %s)
                        ON CONFLICT (name) DO NOTHING;
                        """,
                        (monster_name, description, image_url, type_id)
                    )

        conn.commit()
        cur.close()
        conn.close()
        print("Monsters added succesfully!")

    except Exception as e:
        print(f"Error:: {e}")

if __name__ == "__main__":
    import_monsters()